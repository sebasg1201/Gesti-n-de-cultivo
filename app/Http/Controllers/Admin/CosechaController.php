<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cosecha;
use App\Models\Terreno;
use App\Models\TipoSemilla;
use App\Models\Estado;
use App\Models\TipoRiego;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class CosechaController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function buscarTerrenos(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $query = $request->get('q');

        $terrenos = Terreno::with('tipoSuelo')
            ->where('id_empresa', $id_empresa)
            ->where('id_estado', 7) // Disponible
            ->where('nombre', 'LIKE', "%{$query}%")
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id_terreno,
                    'nombre' => $t->nombre,
                    'area' => $t->area_m2 ?? ($t->Ancho * $t->Largo),
                    'suelo' => $t->tipoSuelo->nombre ?? 'N/A',
                    'impacto' => $t->tipoSuelo->impacto_dias ?? 0
                ];
            });

        return response()->json($terrenos);
    }

    public function buscarEspecies(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $query = $request->get('q');

        $especies = TipoSemilla::where('id_empresa', $id_empresa)
            ->where('nombre_semilla', 'LIKE', "%{$query}%")
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id_semilla,
                    'nombre' => $s->nombre_semilla,
                    'stock' => $s->stock_actual,
                    'espacio' => $s->espacio_por_planta_m2 ?? 0.5,
                    'yield' => $s->rendimiento_promedio,
                    'base_dias' => $s->tiempo_base_dias ?? 0
                ];
            });

        return response()->json($especies);
    }

    public function index(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $faseFilter = $request->get('fase');
        $month = $request->get('month');
        $year = $request->get('year');

        $query = Cosecha::where('id_empresa', $id_empresa)
            ->whereNotIn('id_estado', [10, 14]) // Excluir Programados (10) y Finalizados (14)
            ->with(['terreno', 'semilla']);

        if ($month) {
            $query->whereMonth('fecha_siembra', $month);
        }
        if ($year) {
            $query->whereYear('fecha_siembra', $year);
        }

        // Filtrado por fase (aproximación en SQL para mantener paginación)
        if ($faseFilter) {
            $query->whereRaw("
                (CASE 
                    WHEN (DATEDIFF(NOW(), fecha_siembra) / DATEDIFF(fecha_estimada, fecha_siembra) * 100) < 20 THEN 'Siembra'
                    WHEN (DATEDIFF(NOW(), fecha_siembra) / DATEDIFF(fecha_estimada, fecha_siembra) * 100) < 50 THEN 'Vegetativo'
                    WHEN (DATEDIFF(NOW(), fecha_siembra) / DATEDIFF(fecha_estimada, fecha_siembra) * 100) < 75 THEN 'Floración'
                    WHEN (DATEDIFF(NOW(), fecha_siembra) / DATEDIFF(fecha_estimada, fecha_siembra) * 100) < 90 THEN 'Llenado'
                    ELSE 'Cosecha'
                END) = ?", [$faseFilter]);
        }

        $cosechas = $query->orderBy('id_cosecha', 'desc')->paginate(9);

        $terrenos = Terreno::with('tipoSuelo')->where('id_empresa', $id_empresa)->where('id_estado', 7)->get(); // 7 = Disponible
        $semillas = TipoSemilla::where('id_empresa', $id_empresa)->get();
        $riegos = TipoRiego::where('id_empresa', $id_empresa)->get();

        return view('admin.cosechas.index', compact('cosechas', 'terrenos', 'semillas', 'riegos'));
    }

    public function exportCSV(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $month = $request->get('month');
        $year = $request->get('year');

        $query = Cosecha::with(['terreno', 'semilla'])
            ->where('id_empresa', $id_empresa);

        if ($month) {
            $query->whereMonth('fecha_siembra', $month);
        }
        if ($year) {
            $query->whereYear('fecha_siembra', $year);
        }

        $cosechas = $query->get();

        $filename = "reporte_cosechas_" . date('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Semilla', 'Terreno', 'Cantidad', 'F. Siembra', 'F. Estimada'];

        $callback = function () use ($cosechas, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM for UTF-8
            fputcsv($file, $columns, ';');

            foreach ($cosechas as $cosecha) {
                fputcsv($file, [
                    $cosecha->id_cosecha,
                    $cosecha->semilla->nombre ?? 'N/A',
                    $cosecha->terreno->nombre ?? 'N/A',
                    $cosecha->Cantidad,
                    $cosecha->fecha_siembra,
                    $cosecha->fecha_estimada
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function store(Request $request)
    {
        $id_empresa = $this->getEmpresaId();

        $request->validate([
            'id_terreno' => 'required|exists:terreno,id_terreno',
            'id_semilla' => 'required|exists:tipo_semilla,id_semilla',
            'id_tipo_riego' => 'required|exists:tipo_riego,id_tipo_riego',
            'cantidad_sembrada' => 'required|numeric|min:1',
            'fecha_siembra' => 'required|date',
            'fecha_inicio_riego' => 'required|date|after_or_equal:fecha_siembra',
            'frecuencia_riego_dias' => 'required|integer|min:1',
            'litros_por_riego' => 'required|numeric|min:1',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $semilla = TipoSemilla::findOrFail($request->id_semilla);
        $terreno = Terreno::with('tipoSuelo')->findOrFail($request->id_terreno);

        if ($terreno->id_estado != 7) {
            return redirect()->back()->with('error', 'El terreno seleccionado está ocupado y no se puede usar para una nueva siembra.')->withInput();
        }

        $riego = TipoRiego::findOrFail($request->id_tipo_riego);

        $imagePath = null;
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('cosechas', 'public');
        }

        $baseDays = $semilla->tiempo_base_dias ?? 0;
        $soilImpact = $terreno->tipoSuelo ? $terreno->tipoSuelo->impacto_dias : 0;
        $irrigationImpact = $riego->impacto_dias ?? 0;

        $totalDays = (int) ($baseDays + $soilImpact + $irrigationImpact);

        $fechaEstimada = \Carbon\Carbon::parse($request->fecha_siembra)->addDays($totalDays);

        // 1. Validation: Terrain Capacity Density
        $area = $terreno->area_m2 ?? ($terreno->Ancho * $terreno->Largo);
        $espacio = $semilla->espacio_por_planta_m2 > 0 ? $semilla->espacio_por_planta_m2 : 0.5;
        $capacidadMaxima = $area / $espacio;

        if ($request->cantidad_sembrada > $capacidadMaxima) {
            return redirect()->back()->with('error', 'El lote no tiene espacio suficiente para esta densidad de siembra (Máx: ' . floor($capacidadMaxima) . ' plantas).')->withInput();
        }

        // 2. Validation: Inventory Stock
        if ($request->cantidad_sembrada > $semilla->stock_actual) {
            return redirect()->back()->with('error', 'Stock insuficiente en almacén (Disponible: ' . $semilla->stock_actual . ').')->withInput();
        }

        // Deduct inventory
        $semilla->stock_actual -= $request->cantidad_sembrada;
        $semilla->save();

        // 3. Crear la Cosecha en estado "Programado" (10) para Siembra
        $cosecha = Cosecha::create([
            'id_empresa' => $id_empresa,
            'id_terreno' => $request->id_terreno,
            'id_semilla' => $request->id_semilla,
            'id_estado' => 10, // 10 = Siembra / Programado
            'Cantidad' => $request->cantidad_sembrada,
            'fecha_siembra' => $request->fecha_siembra,
            'frecuencia_riego_dias' => $request->frecuencia_riego_dias,
            'fecha_estimada' => $fechaEstimada->format('Y-m-d'),
            'produccion_estimada' => $request->cantidad_sembrada * $semilla->rendimiento_promedio,
            'litros_por_riego' => $request->litros_por_riego,
            'imagenes' => $imagePath,
            // id_tipo_riego no está en la tabla cosecha, lo pasaremos en la descripción de la tarea
        ]);

        // 4. Asignar Tarea de Siembra automáticamente
        $id_asignado = $this->obtenerTrabajadorMenosCarga($id_empresa);

        if ($id_asignado) {
            \App\Models\FaseProgramada::create([
                'id_terreno' => $request->id_terreno,
                'documento_trabajador' => $id_asignado,
                'descripcion' => 'Realizar Siembra de ' . number_format($request->cantidad_sembrada, 0) . ' de ' . $semilla->nombre_semilla . ' en lote ' . ($terreno->nombre ?? 'N/A') . ' [TIPO_RIEGO:' . $request->id_tipo_riego . '] [INICIO_RIEGO:' . $request->fecha_inicio_riego . ']',
                'fecha_programada' => $request->fecha_siembra . ' ' . date('H:i:s'),
                'id_estado' => 1 // Pendiente
            ]);

            return redirect()->route('admin.cosechas.index')->with('success', 'Siembra programada. Se ha asignado una tarea al trabajador con la menor carga.');
        } else {
            // Caso borde: no hay trabajadores
            session()->flash('warning', 'Aviso: No hay trabajadores registrados. La tarea de siembra no fue asignada.');
            return redirect()->route('admin.cosechas.index')->with('success', 'Siembra iniciada. Registra trabajadores para asignar la tarea de siembra.');
        }
    }

    /**
     * Obtiene el documento del trabajador con la menor carga de tareas activas.
     */
    private function obtenerTrabajadorMenosCarga($id_empresa)
    {
        $queryTrabajadores = \App\Models\Usuario::where('id_empresa', $id_empresa)
            ->where('id_tipo_usuario', 3); // 3 = trabajador

        // Prioridad 1: disponibles (id_estado_trabajador=1) y activos (id_estado=1)
        $trabajadores = (clone $queryTrabajadores)
            ->where('id_estado', 1)
            ->where('id_estado_trabajador', 1)
            ->get();

        // Prioridad 2: si no hay disponibles, buscar cualquier trabajador activo
        if ($trabajadores->isEmpty()) {
            $trabajadores = (clone $queryTrabajadores)
                ->where('id_estado', 1)
                ->get();
        }

        // Prioridad 3: cualquier trabajador de la empresa sin importar estado
        if ($trabajadores->isEmpty()) {
            $trabajadores = $queryTrabajadores->get();
        }

        if ($trabajadores->isEmpty()) return null;

        $cargasTrabajo = [];
        foreach ($trabajadores as $t) {
            // Contar riegos, insumos y fases pendientes
            $cargaRiego = \App\Models\Riego::where('documento_trabajador', $t->documento)
                ->whereIn('id_estado', [1, 17])->count();
            
            $cargaInsumo = \App\Models\InsumoCosecha::where('documento_trabajador', $t->documento)
                ->whereIn('id_estado', [1, 17])->count();
                
            $cargaFase = \App\Models\FaseProgramada::where('documento_trabajador', $t->documento)
                ->whereIn('id_estado', [1, 17])->count();

            $cargasTrabajo[$t->documento] = $cargaRiego + $cargaInsumo + $cargaFase;
        }

        asort($cargasTrabajo);
        reset($cargasTrabajo);
        return key($cargasTrabajo);
    }

    public function show(Request $request, $id)
    {
        $id_empresa = $this->getEmpresaId();

        $cosecha = Cosecha::where('id_empresa', $id_empresa)
            ->with(['terreno', 'terreno.tipoSuelo', 'semilla', 'cultivos.detalles.producto', 'cultivos.trabajador', 'cultivos.registroTrabajo'])
            ->findOrFail($id);

        $fechaSiembra = \Carbon\Carbon::parse($cosecha->fecha_siembra);
        $fechaEstimada = $cosecha->fecha_estimada ? \Carbon\Carbon::parse($cosecha->fecha_estimada) : null;

        $now = \Carbon\Carbon::now();

        $diasTotales = 0;
        $diasTranscurridos = 0;
        $porcentaje = 0;
        $diasRestantes = 0;

        if ($fechaEstimada) {
            $diasTotales = $fechaSiembra->diffInDays($fechaEstimada);
            $diasTranscurridos = $fechaSiembra->diffInDays($now, false);

            if ($diasTranscurridos < 0) {
                $diasTranscurridos = 0;
            }

            $porcentaje = $diasTotales > 0 ? ($diasTranscurridos / $diasTotales) * 100 : 0;

            if ($porcentaje > 100) {
                $porcentaje = 100;
            }

            $diasRestantes = $now->diffInDays($fechaEstimada, false);
        }

        // Determinar fase actual basada en porcentaje
        $faseActual = 'Siembra';
        if ($porcentaje >= 20 && $porcentaje < 50)
            $faseActual = 'Vegetativo';
        elseif ($porcentaje >= 50 && $porcentaje < 75)
            $faseActual = 'Floración';
        elseif ($porcentaje >= 75 && $porcentaje < 90)
            $faseActual = 'Llenado';
        elseif ($porcentaje >= 90)
            $faseActual = 'Cosecha';

        $riegos = \App\Models\Riego::with(['registroTrabajo', 'usuario'])->where('id_cosecha', $id)->get();

        // Calcular cumplimiento de hidratación
        $ultimoRiego = \App\Models\Riego::where('id_cosecha', $id)
            ->whereDate('fecha_programada', '<=', \Carbon\Carbon::now()->format('Y-m-d'))
            ->orderBy('fecha_programada', 'desc')
            ->first();

        $porcentajeHidratacion = 0;
        if (!$ultimoRiego) {
            $porcentajeHidratacion = 100;
        } else {
            if ($ultimoRiego->id_estado == 15) {
                $porcentajeHidratacion = 100;
            } elseif ($ultimoRiego->id_estado == 17) {
                $porcentajeHidratacion = 50;
            } else {
                $porcentajeHidratacion = 0;
            }
        }

        $totalRiegosCiclo = $riegos->count();
        $riegosCompletados = $riegos->where('id_estado', 15)->count();

        $insumos = \App\Models\InsumoCosecha::with(['insumo', 'registroTrabajo', 'usuario'])->where('id_cosecha', $id)->get();

        $historial = collect();

        foreach ($riegos as $r) {
            $r->tipo_historial = 'riego';
            $r->fecha_historial = $r->fecha_programada;
            $r->titulo_historial = 'Riego';
            $r->descripcion_historial = $r->observaciones;
            $r->observacion_trabajador = $r->registroTrabajo->observacion ?? null;
            $r->id_estado_real = $r->id_estado;


            if ($r->id_estado == 15) {
                $r->estado_historial = 'Completado';
            } elseif ($r->id_estado == 16 || $r->id_estado == 18) {
                $r->estado_historial = 'Perdida';
            } elseif ($r->id_estado == 17) {
                $r->estado_historial = 'En Proceso';
            } elseif ($r->id_estado == 19) {
                $r->estado_historial = 'Retraso';
            } else {
                $r->estado_historial = 'Pendiente';
            }
            $historial->push($r);
        }

        foreach ($insumos as $i) {
            $i->tipo_historial = 'insumo';
            $i->fecha_historial = $i->fecha_programada;
            $i->titulo_historial = 'Aplicación de Insumo';
            $cantidadLimpia = (float) $i->cantidad_usada;
            $i->descripcion_historial = ($i->insumo->Nombre ?? 'Insumo') . ' (Cant: ' . $cantidadLimpia . ')';
            $i->observacion_trabajador = $i->registroTrabajo->observacion ?? null;
            $i->id_estado_real = $i->id_estado;

            $i->estado_historial = in_array($i->id_estado, [15]) ? 'Completado' : ($i->id_estado == 19 ? 'Retraso' : ($i->id_estado == 17 ? 'En Proceso' : (in_array($i->id_estado, [16, 18]) ? 'Perdida' : 'Pendiente')));
            $historial->push($i);
        }

        foreach ($cosecha->cultivos as $c) {
            $c->tipo_historial = 'recoleccion';
            $c->fecha_historial = $c->fecha_recoleccion;
            $c->titulo_historial = 'RECOLECCIÓN';
            
            // Recopilar cantidad y calidad de los detalles
            $totalCant = $c->detalles->sum('cantidad');
            $calidades = $c->detalles->pluck('calidad')->unique()->filter()->implode(', ');
            $detallesStr = $totalCant > 0 ? " (Cant: {$totalCant}" . ($calidades ? " - Cali: {$calidades}" : "") . ")" : "";
            
            $c->descripcion_historial = $c->descripcion_recoleccion . $detallesStr;
            $c->observacion_trabajador = $c->registroTrabajo->observacion ?? null;
            $c->id_estado_real = $c->id_estado;

            if ($c->id_estado == 15) {
                $c->estado_historial = 'Completado';
            } elseif ($c->id_estado == 19) {
                $c->estado_historial = 'Retraso';
            } elseif ($c->id_estado == 16 || $c->id_estado == 18) {
                $c->estado_historial = 'Perdida';
            } elseif ($c->id_estado == 17) {
                $c->estado_historial = 'En Proceso';
            } else {
                $c->estado_historial = 'Pendiente';
            }
            $historial->push($c);
        }

        // Aplicar Filtro de Tipo (Riego / Insumo)
        $typeFilter = $request->get('type');
        if ($typeFilter) {
            $historial = $historial->filter(function ($item) use ($typeFilter) {
                return $item->tipo_historial === $typeFilter;
            });
        }

        // Aplicar Filtro de Estado
        $statusFilter = $request->get('status');
        if ($statusFilter) {
            $historial = $historial->filter(function ($item) use ($statusFilter) {
                if ($statusFilter === 'Completado') return $item->id_estado_real == 15;
                if ($statusFilter === 'Pendiente') return $item->id_estado_real == 1;
                if ($statusFilter === 'En Proceso') return $item->id_estado_real == 17;
                if ($statusFilter === 'Perdida') return in_array($item->id_estado_real, [16, 18]);
                if ($statusFilter === 'Retraso') return $item->id_estado_real == 19;
                return true;
            });
        }


        $historial = $historial->sortByDesc('fecha_historial');

        // Paginación manual de la colección
        $currentPage = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 5;
        $currentItems = $historial->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedHistorial = new LengthAwarePaginator($currentItems, $historial->count(), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),
            'query' => $request->query(),
        ]);

        return view('admin.cosechas.show', [
            'cosecha' => $cosecha,
            'diasTotales' => $diasTotales,
            'diasTranscurridos' => $diasTranscurridos,
            'porcentaje' => $porcentaje,
            'diasRestantes' => $diasRestantes,
            'faseActual' => $faseActual,
            'porcentajeHidratacion' => $porcentajeHidratacion,
            'riegosCompletados' => $riegosCompletados,
            'totalRiegosCiclo' => $totalRiegosCiclo,
            'historial' => $paginatedHistorial
        ]);
    }


    public function exportHistory($id)
    {
        $id_empresa = $this->getEmpresaId();
        $cosecha = Cosecha::where('id_empresa', $id_empresa)->with(['terreno', 'semilla', 'cultivos.trabajador'])->findOrFail($id);

        $riegos = \App\Models\Riego::with('registroTrabajo')->where('id_cosecha', $id)->get();
        $insumos = \App\Models\InsumoCosecha::with(['insumo', 'registroTrabajo'])->where('id_cosecha', $id)->get();

        $rows = collect();

        foreach ($riegos as $r) {
            $rows->push([
                'Fecha' => $r->fecha_programada,
                'Actividad' => 'Riego',
                'Detalle' => $r->observaciones,
                'Estado' => in_array($r->id_estado, [15]) ? 'Completado' : 'Otro',
                'Obs. Trabajador' => $r->registroTrabajo->observacion ?? ''
            ]);
        }

        foreach ($insumos as $i) {
            $rows->push([
                'Fecha' => $i->fecha_programada,
                'Actividad' => 'Insumo',
                'Detalle' => ($i->insumo->Nombre ?? 'Insumo') . ' (Cant: ' . (float)$i->cantidad_usada . ')',
                'Estado' => in_array($i->id_estado, [15]) ? 'Completado' : 'Otro',
                'Obs. Trabajador' => $i->registroTrabajo->observacion ?? ''
            ]);
        }

        foreach ($cosecha->cultivos as $c) {
            $rows->push([
                'Fecha' => $c->fecha_recoleccion,
                'Actividad' => 'Recolección',
                'Detalle' => $c->descripcion_recoleccion,
                'Estado' => in_array($c->id_estado, [15]) ? 'Completado' : 'Otro',
                'Obs. Trabajador' => $c->registroTrabajo->observacion ?? ''
            ]);
        }

        $rows = $rows->sortByDesc('Fecha');

        $filename = "historial_cosecha_" . $id . "_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Fecha', 'Actividad', 'Detalle', 'Estado', 'Observación Trabajador'];

        $callback = function () use ($rows, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM
            fputcsv($file, $columns, ';');
            foreach ($rows as $row) {
                fputcsv($file, array_values($row), ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
