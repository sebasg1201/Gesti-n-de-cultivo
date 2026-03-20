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

class CosechaController extends Controller
{
    private function getEmpresaId()
    {
        return Auth::guard('usuario')->user()->id_empresa;
    }

    public function index(Request $request)
    {
        $id_empresa = $this->getEmpresaId();
        $faseFilter = $request->get('fase');
        $month = $request->get('month');
        $year = $request->get('year');

        $query = Cosecha::where('id_empresa', $id_empresa)
            ->where('id_estado', '!=', 14)
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

        $callback = function() use($cosechas, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM for UTF-8
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
        $area = $terreno->area_m2 ?? ($terreno->Ancho * $terreno->Alto);
        $espacio = $semilla->espacio_por_planta_m2 > 0 ? $semilla->espacio_por_planta_m2 : 0.25;
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

        $aguaPorRiego = $request->litros_por_riego;

        $cosecha = Cosecha::create([
            'id_empresa' => $id_empresa,
            'id_terreno' => $request->id_terreno,
            'id_semilla' => $request->id_semilla,
            'id_estado' => 1, // Default state
            'Cantidad' => $request->cantidad_sembrada,
            'fecha_siembra' => $request->fecha_siembra,
            'frecuencia_riego_dias' => $request->frecuencia_riego_dias,
            'fecha_estimada' => $fechaEstimada->format('Y-m-d'),
            'produccion_estimada' => $request->cantidad_sembrada * $semilla->rendimiento_promedio,
            'litros_por_riego' => $request->litros_por_riego,
            'imagenes' => $imagePath,
        ]);

        $terreno->id_estado = 6; // Ocupado (ID 6)
        $terreno->save();

        // Automated Task Generation logic
        if ($totalDays > 0) {
            $frecuencia = (int) $request->frecuencia_riego_dias;
            $fecha_actual_bucle = \Carbon\Carbon::parse($request->fecha_siembra);

            // === Selección del trabajador con menos carga ===
            // Solo se consideran TRABAJADORES (id_tipo_usuario=3) de la empresa.
            // Primero se buscan disponibles; si no hay, se amplía a todos los trabajadores activos.
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

            $trabajadoresCount = $trabajadores->count();
            $cargasTrabajo = [];

            if ($trabajadoresCount > 0) {
                foreach ($trabajadores as $t) {
                    $cargasTrabajo[$t->documento] = \App\Models\Riego::where('documento_trabajador', $t->documento)
                        ->whereIn('id_estado', [1, 17]) // 1=Pendiente, 17=En Proceso
                        ->count();
                }
                // Ordenar de menor a mayor carga
                asort($cargasTrabajo);
                reset($cargasTrabajo);
                $id_asignado = key($cargasTrabajo);
            } else {
                // No hay trabajadores en la empresa — no crear la tarea
                session()->flash('warning', 'Aviso: No hay trabajadores registrados en la empresa. La tarea de riego no fue asignada.');
                return redirect()->route('admin.cosechas.index')->with('success', 'Siembra iniciada. Registra trabajadores para asignar tareas de riego.');
            }

            // Al ser el riego inicial (día 0), si la fecha es hoy, ponerle la hora actual
            $fechaProgramada = $fecha_actual_bucle->copy();
            if ($fechaProgramada->isToday()) {
                $fechaProgramada->setTimeFrom(\Carbon\Carbon::now());
            }

            $obs = 'Aplicar ' . $aguaPorRiego . 'L en ' . $terreno->nombre . ' al cultivo de ' . $semilla->nombre_semilla . '.';

            \App\Models\Riego::create([
                'cant_agua_apl' => $aguaPorRiego,
                'id_tipo_riego' => $request->id_tipo_riego,
                'id_cosecha' => $cosecha->id_cosecha,
                'documento_trabajador' => $id_asignado,
                'id_estado' => 1, // 1 = Pendiente
                'fecha_programada' => $fechaProgramada->format('Y-m-d H:i:s'),
                'observaciones' => $obs,
            ]);
            // Los siguientes riegos se crearán automáticamente cada X días mediante un comando programado
        }

        return redirect()->route('admin.cosechas.index')->with('success', 'Siembra iniciada y tareas de riego automáticas generadas.');
    }

    public function show($id)
    {
        $id_empresa = $this->getEmpresaId();

        $cosecha = Cosecha::where('id_empresa', $id_empresa)
            ->with(['terreno', 'terreno.tipoSuelo', 'semilla', 'cultivos.detalles.producto', 'cultivos.trabajador'])
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
            $diasTranscurridos = $fechaSiembra->diffInDays($now, false); // false para permitir negativos si la siembra es futura

            if ($diasTranscurridos < 0) {
                $diasTranscurridos = 0;
            }

            $porcentaje = $diasTotales > 0 ? ($diasTranscurridos / $diasTotales) * 100 : 0;

            if ($porcentaje > 100) {
                $porcentaje = 100;
            }

            $diasRestantes = $now->diffInDays($fechaEstimada, false);
        }

        // Determinar fase actual basada en porcentaje (Aproximación general)
        $faseActual = 'Siembra';
        if ($porcentaje >= 20 && $porcentaje < 50)
            $faseActual = 'Vegetativo';
        elseif ($porcentaje >= 50 && $porcentaje < 75)
            $faseActual = 'Floración';
        elseif ($porcentaje >= 75 && $porcentaje < 90)
            $faseActual = 'Llenado';
        elseif ($porcentaje >= 90)
            $faseActual = 'Cosecha';

        $riegos = \App\Models\Riego::where('id_cosecha', $id)->get();

        // Calcular cumplimiento de hidratación (Barra Azul - Estado Tarea Actual)
        $ultimoRiego = \App\Models\Riego::where('id_cosecha', $id)
            ->whereDate('fecha_programada', '<=', \Carbon\Carbon::now()->format('Y-m-d'))
            ->orderBy('fecha_programada', 'desc')
            ->first();

        $porcentajeHidratacion = 0;
        if (!$ultimoRiego) {
            $porcentajeHidratacion = 100; // Sin riego programado = ciclo limpio
        } else {
            if ($ultimoRiego->id_estado == 15) {        // Realizado
                $porcentajeHidratacion = 100;
            } elseif ($ultimoRiego->id_estado == 17) {  // En Proceso
                $porcentajeHidratacion = 50;
            } else {                                     // Pendiente / Perdida
                $porcentajeHidratacion = 0;
            }
        }

        $totalRiegosCiclo = $riegos->count();
        $riegosCompletados = $riegos->where('id_estado', 15)->count();

        $insumos = \App\Models\InsumoCosecha::with('insumo')->where('id_cosecha', $id)->get();
        $fases = \App\Models\FaseProgramada::where('id_cosecha', $id)->get();

        $historial = collect();

        foreach ($riegos as $r) {
            $r->tipo_historial = 'riego';
            $r->fecha_historial = $r->fecha_programada;
            $r->titulo_historial = 'Riego';
            $r->descripcion_historial = $r->observaciones;

            if ($r->id_estado == 15) {
                $r->estado_historial = 'Completado';
            } elseif ($r->id_estado == 16 || $r->id_estado == 18) {
                $r->estado_historial = 'Perdida';
            } elseif ($r->id_estado == 17) {   // En Proceso
                $r->estado_historial = 'En Proceso';
            } else {
                $r->estado_historial = 'Pendiente';
            }
            $historial->push($r);
        }

        foreach ($insumos as $i) {
            $i->tipo_historial = 'insumo';
            $i->fecha_historial = $i->fecha_programada;
            $i->titulo_historial = 'Aplicación de Insumo';
            $i->descripcion_historial = ($i->insumo->Nombre ?? 'Insumo') . ' (Cant: ' . $i->cantidad_usada . ')';
            $i->estado_historial = in_array($i->id_estado, [15]) ? 'Completado' : ($i->id_estado == 17 ? 'En Proceso' : (in_array($i->id_estado, [16, 18]) ? 'Perdida' : 'Pendiente'));
            $historial->push($i);
        }

        foreach ($fases as $f) {
            $f->tipo_historial = 'fase';
            $f->fecha_historial = $f->fecha_programada;
            $f->titulo_historial = 'Fase de Mantenimiento';
            $f->descripcion_historial = $f->descripcion;
            $f->estado_historial = in_array($f->id_estado, [15]) ? 'Completado' : ($f->id_estado == 17 ? 'En Proceso' : (in_array($f->id_estado, [16, 18]) ? 'Perdida' : 'Pendiente'));
            $historial->push($f);
        }

        $historial = $historial->sortByDesc('fecha_historial');

        return view('admin.cosechas.show', compact('cosecha', 'diasTotales', 'diasTranscurridos', 'porcentaje', 'diasRestantes', 'faseActual', 'porcentajeHidratacion', 'riegosCompletados', 'totalRiegosCiclo', 'historial'));
    }
}
