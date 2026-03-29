<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        $usuario = auth()->guard('usuario')->user();

        if (!$usuario) {
            return redirect()->route('usuario.login');
        }

        // Si es supervisor (2) o trabajador (3), redirigir a su propio dashboard
        if (in_array($usuario->id_tipo_usuario, [2, 3])) {
            return redirect()->route('trabajador.dashboard');
        }

        $id_empresa = $usuario->id_empresa;

        // 1. Trabajadores Activos
        $totalTrabajadores = \App\Models\Usuario::where('id_empresa', $id_empresa)->where('id_tipo_usuario', 3)->count();
        $trabajadoresActivos = \App\Models\Usuario::where('id_empresa', $id_empresa)
            ->where('id_tipo_usuario', 3)
            ->where('id_estado_trabajador', 1) // Asumiendo 1 = Activo
            ->count();

        // 2. Alertas Urgentes (Soporte pendiente)
        $alertasUrgentes = \App\Models\Soporte::where('id_empresa', $id_empresa)
            ->where('estado', 'Pendiente')
            ->count();

        // 3. Cosechas en Proceso
        $cosechasEnProceso = \App\Models\Cosecha::where('id_empresa', $id_empresa)->count(); // Simplified for now

        // 4. Progreso Tareas ULTIMOS 7 DIAS (Fases, Riegos e Insumos) - Rolling window
        $inicioSemana = \Carbon\Carbon::now()->subDays(7)->startOfDay();
        $finSemana = \Carbon\Carbon::now()->endOfDay();

        // Totales de la semana
        $fasesSemanaTotal = \App\Models\FaseProgramada::whereHas('terreno', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->whereBetween('fecha_programada', [$inicioSemana, $finSemana])->count();

        $riegosSemanaTotal = \App\Models\Riego::whereHas('cosecha', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->whereBetween('fecha_programada', [$inicioSemana, $finSemana])->count();

        $insumosSemanaTotal = \App\Models\InsumoCosecha::whereHas('cosecha', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->whereBetween('fecha_programada', [$inicioSemana, $finSemana])->count();

        $totalTareasSemana = $fasesSemanaTotal + $riegosSemanaTotal + $insumosSemanaTotal;

        // Completadas de la semana (9 = Realizado/Aplicado, 15 = Completado/Realizado)
        $fasesSemanaCompletas = \App\Models\FaseProgramada::whereHas('terreno', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->whereBetween('fecha_programada', [$inicioSemana, $finSemana])->whereIn('id_estado', [9, 15])->count();

        $riegosSemanaCompletas = \App\Models\Riego::whereHas('cosecha', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->whereBetween('fecha_programada', [$inicioSemana, $finSemana])->whereIn('id_estado', [9, 15])->count();

        $insumosSemanaCompletas = \App\Models\InsumoCosecha::whereHas('cosecha', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->whereBetween('fecha_programada', [$inicioSemana, $finSemana])->whereIn('id_estado', [9, 15])->count();

        $totalCompletasSemana = $fasesSemanaCompletas + $riegosSemanaCompletas + $insumosSemanaCompletas;

        $progresoTareas = $totalTareasSemana > 0 ? round(($totalCompletasSemana / $totalTareasSemana) * 100) : 0;

        // 5. Estado de Cultivos (primeros 4 para la tarjeta)
        $cultivos = \App\Models\Cosecha::with(['terreno', 'semilla'])
            ->where('id_empresa', $id_empresa)
            ->take(2)
            ->get();

        // 6. Seguimiento de Equipo (Actividad reciente)
        $equipo = \App\Models\Usuario::where('id_empresa', $id_empresa)
            ->where('id_tipo_usuario', 3)
            ->with(['estadoTrabajador'])
            ->take(5)
            ->get();

        foreach ($equipo as $miembro) {
            $ultimaFase = \App\Models\FaseProgramada::where('documento_trabajador', $miembro->documento)
                ->orderBy('fecha_programada', 'desc')
                ->first();

            $miembro->actividad_reciente = $ultimaFase ? $ultimaFase->descripcion : 'Sin actividad reciente';
            $miembro->tiempo_actividad = $ultimaFase ? \Carbon\Carbon::parse($ultimaFase->fecha_programada)->diffForHumans() : '';
            // Determine active status mock if not set
            $miembro->is_active = $miembro->id_estado_trabajador == 1;
        }

        // 7. Alertas (Lista)
        $listaAlertas = \App\Models\Soporte::where('id_empresa', $id_empresa)
            ->where('estado', 'Pendiente')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // 8. Tareas de Hoy (Lista Consolidada para el sidebar) - EXACTAMENTE HOY
        $hoy = \Carbon\Carbon::now()->format('Y-m-d');

        $fasesHoy = \App\Models\FaseProgramada::with(['usuario', 'terreno'])
            ->whereHas('terreno', function ($q) use ($id_empresa) {
                $q->where('id_empresa', $id_empresa);
            })->whereDate('fecha_programada', $hoy)
            ->get()->map(function ($t) {
                $t->tipo_tarea = 'fase';
                return $t;
            });

        $riegosHoy = \App\Models\Riego::with(['usuario', 'cosecha.semilla', 'tipoRiego'])
            ->whereHas('cosecha', function ($q) use ($id_empresa) {
                $q->where('id_empresa', $id_empresa);
            })->whereDate('fecha_programada', $hoy)
            ->get()->map(function ($t) {
                $t->tipo_tarea = 'riego';
                $t->descripcion = $t->observaciones ?: ('Riego: ' . ($t->tipoRiego?->tipo_riego ?? 'General'));
                return $t;
            });

        $insumosHoy = \App\Models\InsumoCosecha::with(['usuario', 'cosecha.semilla', 'insumo'])
            ->whereHas('cosecha', function ($q) use ($id_empresa) {
                $q->where('id_empresa', $id_empresa);
            })->whereDate('fecha_programada', $hoy)
            ->get()->map(function ($t) {
                $t->tipo_tarea = 'insumo';
                $t->descripcion = 'Aplicación de Insumo: ' . ($t->insumo?->Nombre ?? 'Desconocido');
                return $t;
            });

        $listaTareasHoy = $fasesHoy->concat($riegosHoy)->concat($insumosHoy)
            ->sortBy('id_estado') // O cualquier otro criterio
            ->take(3); // Solo 3 como solicitó el usuario

        // 9. Terrenos para el clima rotativo
        $terrenosClima = \App\Models\Terreno::where('id_empresa', $id_empresa)
            ->with([
                'cosechas' => function ($q) {
                    $q->with('semilla')->where('id_estado', 1)->take(1); // 1 = Activo (asumiendo)
                }
            ])->get()->map(function ($terreno) {
                $cosecha = $terreno->cosechas->first();
                return [
                    'nombre' => $terreno->nombre,
                    'ubicacion' => $terreno->ubicacion,
                    'latitud' => $terreno->latitud,
                    'longitud' => $terreno->longitud,
                    'cosecha' => $cosecha ? $cosecha->semilla->nombre_semilla : 'Sin cosecha activa'
                ];
            });

        // 10. Estado del Terreno (Mock data with real context combined)
        // Intentar obtener el terreno de la primera cosecha activa
        $cosechaActiva = \App\Models\Cosecha::with('terreno.tipoSuelo')->where('id_empresa', $id_empresa)->first();
        $humedad = 70; // Default
        $ph = 6.5;    // Default
        if ($cosechaActiva && $cosechaActiva->terreno?->tipoSuelo) {
            // Ajustar valores basados en el tipo de suelo
            $tipoSuelo = strtolower($cosechaActiva->terreno->tipoSuelo->nombre ?? '');
            if (str_contains($tipoSuelo, 'arenoso')) {
                $humedad = 40;
                $ph = 7.0;
            } elseif (str_contains($tipoSuelo, 'arcilloso')) {
                $humedad = 85;
                $ph = 5.5;
            } elseif (str_contains($tipoSuelo, 'franco')) {
                $humedad = 65;
                $ph = 6.8;
            }

            // Simular impacto del ultimo riego
            $ultimoRiego = \App\Models\Riego::where('id_cosecha', $cosechaActiva->id_cosecha)
                ->where('id_estado', 9)
                ->orderBy('fecha_programada', 'desc')->first();
            if ($ultimoRiego && isset($ultimoRiego->fecha_programada) && \Carbon\Carbon::parse($ultimoRiego->fecha_programada)->diffInDays(now()) < 2) {
                $humedad = min(100, $humedad + 20); // Aumentar humedad temporalmente
            }
        }

        $latitud = 4.6097; // Bogotá por defecto
        $longitud = -74.0817;

        if ($cosechaActiva && $cosechaActiva->terreno) {
            $latitud = $cosechaActiva->terreno->latitud ?? $latitud;
            $longitud = $cosechaActiva->terreno->longitud ?? $longitud;
        } else {
            $primerTerreno = \App\Models\Terreno::where('id_empresa', $id_empresa)->first();
            if ($primerTerreno) {
                $latitud = $primerTerreno->latitud ?? $latitud;
                $longitud = $primerTerreno->longitud ?? $longitud;
            }
        }

        $estadoTerreno = [
            'humedad' => $humedad,
            'ph' => $ph,
            'nitrogeno' => rand(30, 60), // Mock NPK
            'fosforo' => rand(15, 30),
            'potasio' => rand(80, 150),
            'latitud' => $latitud,
            'longitud' => $longitud
        ];

        $stats = [
            'trabajadores_activos' => $trabajadoresActivos,
            'total_trabajadores' => $totalTrabajadores,
            'alertas_urgentes' => $alertasUrgentes,
            'cosechas_en_proceso' => $cosechasEnProceso,
            'progreso_tareas' => $progresoTareas,
            'cultivos' => $cultivos,
            'equipo' => $equipo,
            'lista_alertas' => $listaAlertas,
            'lista_tareas_hoy' => $listaTareasHoy,
            'estado_terreno' => $estadoTerreno,
            'terrenos_clima' => $terrenosClima,
        ];

        $stats['trabajos_en_proceso'] = \App\Models\FaseProgramada::whereHas('usuario', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->where('id_estado', 8)->count(); // 8 = En Proceso

        $stats['trabajos_realizados'] = \App\Models\FaseProgramada::whereHas('usuario', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->where('id_estado', 15)->count(); // 15 = Realizado

        return view('admin.inicio', compact('stats'));
    }

    public function configuracion()
    {
        return view('admin.configuracion.index');
    }

    public function trabajadorInicio()
    {
        $usuario = auth()->guard('usuario')->user();

        // 1. Fase Programada (General Tasks)
        $fases = \App\Models\FaseProgramada::with(['terreno.tipoSuelo'])
            ->where('documento_trabajador', $usuario->documento)
            ->whereIn('id_estado', [1, 16, 17]) // Pendiente, Perdida y En Proceso
            ->get()->map(function ($t) {
                $t->tipo_tarea = 'fase';
                // Para agrupar uniformemente, usamos id_terreno
                $t->id_agrupador = 'terreno_' . $t->id_terreno;
                return $t;
            });

        // 2. Riego
        $riegos = \App\Models\Riego::with(['cosecha.semilla', 'cosecha.terreno.tipoSuelo', 'tipoRiego'])
            ->where('documento_trabajador', $usuario->documento)
            ->whereIn('id_estado', [1, 16, 17]) // Pendiente, Perdida y En Proceso
            ->get()->map(function ($t) {
                $t->tipo_tarea = 'riego';
                $t->descripcion = $t->observaciones ?: ('Riego: ' . ($t->tipoRiego?->tipo_riego ?? 'General'));
                $t->id_agrupador = 'terreno_' . ($t->cosecha?->id_terreno ?? '0');
                return $t;
            });

        // 3. Insumos
        $insumos = \App\Models\InsumoCosecha::with(['cosecha.semilla', 'cosecha.terreno.tipoSuelo', 'insumo'])
            ->where('documento_trabajador', $usuario->documento)
            ->whereIn('id_estado', [1, 16, 17]) // Pendiente, Perdida y En Proceso
            ->get()->map(function ($t) {
                $t->tipo_tarea = 'insumo';
                $unidad = $t->insumo?->Unidad_Medida ?? 'unidades';
                $cantidadLimpia = (float) $t->cantidad_usada;
                $cantidadText = $cantidadLimpia > 0 ? " (Usar: {$cantidadLimpia} {$unidad})" : '';
                $t->descripcion = 'Aplicación de Insumo: ' . ($t->insumo?->Nombre ?? 'Desconocido') . $cantidadText;
                $t->id_agrupador = 'terreno_' . ($t->cosecha?->id_terreno ?? '0');
                return $t;
            });

        // 4. Recoleccion
        $recolecciones = \App\Models\Cultivo::with(['cosecha.semilla', 'cosecha.terreno.tipoSuelo'])
            ->where('documento_trabajador', $usuario->documento)
            ->whereIn('id_estado', [1, 16, 17]) // Pendiente, Perdida y En Proceso
            ->get()->map(function ($t) {
                $t->tipo_tarea = 'recoleccion';
                $t->descripcion = 'Cosecha/Recolección';
                $t->id_agrupador = 'terreno_' . ($t->cosecha?->id_terreno ?? '0');
                // Maps fields so they show in dashboard
                $t->fecha_programada = $t->fecha_recoleccion;
                return $t;
            });

        // Unificar y Agrupar por Terreno
        $tareas = $fases->concat($riegos)->concat($insumos)->concat($recolecciones)
            ->sortBy('fecha_programada')
            ->groupBy('id_agrupador');

        // 4. Pagos / Salarios
        $pagos = \App\Models\Salario::with('tipoSalario')
            ->where('documento_trabajador', $usuario->documento)
            ->orderBy('fecha_pago', 'desc')
            ->get();

        return view('trabajadores.trabajador_dashboard', compact('tareas', 'pagos'));
    }

    public function finalizarTarea($id, $tipo)
    {
        $usuario = auth()->guard('usuario')->user();

        $model = $this->getTaskModel($tipo);
        $idField = $this->getTaskIdField($tipo);

        $tarea = $model::where($idField, $id)
            ->where('documento_trabajador', $usuario->documento)
            ->firstOrFail();

        $tarea->update(['id_estado' => 15]); // 15 = Realizado



        return redirect()->route('trabajador.dashboard')->with('success', 'Tarea marcada como finalizada correctamente.');
    }

    public function actualizarEstadoTarea(Request $request, $id, $tipo)
    {
        $usuario = auth()->guard('usuario')->user();

        $request->validate([
            // 1=Pendiente, 17=En Proceso, 15=Realizado, 16=Perdida, 18=Perdida Oculta
            'id_estado' => 'required|integer|in:1,17,15,16,18',
            // La foto es obligatoria solo al finalizar (id_estado=15)
            'evidencia_foto' => ($request->id_estado == 15) ? 'required|image|max:2048' : 'nullable|image|max:2048',
        ]);

        if ($tipo === 'recoleccion' && $request->id_estado == 15) {
            $request->validate([
                'cantidad' => 'required|numeric|min:0.1',
                'calidad' => 'required|string|max:50',
            ]);
        }

        $model = $this->getTaskModel($tipo);
        $idField = $this->getTaskIdField($tipo);

        $tarea = $model::where($idField, $id)
            ->where('documento_trabajador', $usuario->documento)
            ->firstOrFail();

        // Evitar que el trabajador vuelva a un estado anterior
        // Orden lógico: 1 (Pendiente) < 17 (En Proceso) < 15 (Realizado) / 16 (Perdida) < 18 (Perdida Oculta)
        $ordenEstados = [1 => 1, 17 => 2, 15 => 3, 16 => 3, 18 => 4];
        $nuevoEstado = (int) $request->id_estado;
        $estadoActual = (int) $tarea->id_estado;

        if (isset($ordenEstados[$estadoActual]) && isset($ordenEstados[$nuevoEstado]) && $ordenEstados[$nuevoEstado] < $ordenEstados[$estadoActual]) {
            return redirect()->back()->with('error', 'No puedes volver a un estado anterior de la tarea.');
        }

        // Solo actualizamos id_estado en la tabla de la tarea
        $updateData = ['id_estado' => $nuevoEstado];

        // Si el trabajador finaliza la tarea (15=Realizado), guardamos la evidencia en registro_trabajo
        if ($nuevoEstado === 15) {
            // Evitar duplicados: Verificar si ya existe un registro para esta tarea específica
            $existeRegistro = \Illuminate\Support\Facades\DB::table('registro_trabajo')
                ->where('documento_trabajador', $usuario->documento)
                ->where(function ($q) use ($tipo, $id) {
                    if ($tipo === 'insumo')
                        $q->where('id_insumo_cosecha', $id);
                    elseif ($tipo === 'riego')
                        $q->where('id_riego', $id);
                    elseif ($tipo === 'fase')
                        $q->where('id_fase', $id);
                    elseif ($tipo === 'recoleccion')
                        $q->where('id_cultivo', $id);
                })
                ->exists();

            if ($existeRegistro) {
                // Si ya existe registro, solo actualizamos el estado de la tarea (esto se hace al final de la función)
                // saltamos la inserción.
            } else {
                $registroData = [
                    'documento_trabajador' => $usuario->documento,
                    'fecha_trabajada' => now()->toDateString(),
                    'id_estado' => '1',
                    'created_at' => now(),
                ];

                // Foto de evidencia
                if ($request->hasFile('evidencia_foto')) {
                    $path = $request->file('evidencia_foto')->store('evidencias', 'public');
                    $registroData['foto_evidencia'] = $path;
                }

                // Observación del trabajador
                if ($request->filled('observacion_trabajador')) {
                    $registroData['observacion'] = $request->observacion_trabajador;
                }

                // Enlazar con el tipo de tarea correspondiente
                if ($tipo === 'insumo') {
                    $registroData['id_insumo_cosecha'] = $id;
                } elseif ($tipo === 'riego') {
                    $registroData['id_riego'] = $id;
                } elseif ($tipo === 'fase') {
                    $registroData['id_fase'] = $id;
                } elseif ($tipo === 'recoleccion') {
                    $registroData['id_cultivo'] = $id;

                    $cosecha = $tarea->cosecha;
                    $productoNombre = $cosecha && $cosecha->semilla ? $cosecha->semilla->nombre_semilla : 'Producto Recolectado';

                    $producto = \App\Models\Producto::create([
                        'nombre' => $productoNombre,
                        'Codigo_Referencia' => 'REF-' . time() . '-' . rand(100, 999),
                        'descripcion' => 'Producto recolectado de la cosecha #' . ($cosecha ? $cosecha->id_cosecha : 'N/A')
                    ]);

                    \App\Models\DetalleProductoCultivo::create([
                        'id_cultivo' => $tarea->id_cultivo,
                        'id_producto' => $producto->id_producto,
                        'cantidad' => $request->cantidad,
                        'calidad' => $request->calidad
                    ]);
                }

                \Illuminate\Support\Facades\DB::table('registro_trabajo')->insert($registroData);
            }
        } elseif ($nuevoEstado === 18) {
            $registroData = [
                'documento_trabajador' => $usuario->documento,
                'fecha_trabajada' => now()->toDateString(),
                'id_estado' => '1',
                'observacion' => 'Tarea perdida ocultada por el trabajador.',
                'created_at' => now(),
                'id_fase' => ($tipo === 'fase') ? $id : null,
                'id_riego' => ($tipo === 'riego') ? $id : null,
                'id_insumo_cosecha' => ($tipo === 'insumo') ? $id : null,
                'id_cultivo' => ($tipo === 'recoleccion') ? $id : null,
            ];

            \Illuminate\Support\Facades\DB::table('registro_trabajo')->insert($registroData);
        }

        // Actualizar el estado en la tabla de la tarea
        \Illuminate\Support\Facades\DB::table($tarea->getTable())
            ->where($idField, $id)
            ->where('documento_trabajador', $usuario->documento)
            ->update($updateData);

        // Lógica adicional para actualización de fecha estimada de cosecha basada en desempeño e insumos
        $cosecha = null;
        if ($tipo === 'riego' || $tipo === 'insumo') {
            $cosecha = $tarea->cosecha;
        }

        if ($cosecha) {
            // 1. Si la tarea se perdió (16) u ocultó (18), se suma 1 día al ciclo base
            if (in_array($nuevoEstado, [16, 18])) {
                $fechaEstimada = \Carbon\Carbon::parse($cosecha->fecha_estimada)->addDay();
                $cosecha->update(['fecha_estimada' => $fechaEstimada->format('Y-m-d')]);
            }
            // 2. Si es un insumo y se realizó (15), aplicamos su impacto específico
            elseif ($tipo === 'insumo' && $nuevoEstado == 15) {
                $impacto = (int) ($tarea->impacto_dias ?? 0);
                if ($impacto != 0) {
                    $fechaEstimada = \Carbon\Carbon::parse($cosecha->fecha_estimada)->addDays($impacto);
                    $cosecha->update(['fecha_estimada' => $fechaEstimada->format('Y-m-d')]);
                }
            }
        }

        return redirect()->route('trabajador.dashboard')->with('success', '¡Tarea finalizada correctamente! La evidencia fue registrada.');
    }

    private function getTaskModel($tipo)
    {
        switch ($tipo) {
            case 'riego':
                return \App\Models\Riego::class;
            case 'insumo':
                return \App\Models\InsumoCosecha::class;
            case 'recoleccion':
                return \App\Models\Cultivo::class;
            default:
                return \App\Models\FaseProgramada::class;
        }
    }

    private function getTaskIdField($tipo)
    {
        switch ($tipo) {
            case 'riego':
                return 'id_riego';
            case 'insumo':
                return 'id_insumo_cosecha';
            case 'recoleccion':
                return 'id_cultivo';
            default:
                return 'id_fase';
        }
    }



    public function tareasCategorizadas()
    {
        $usuario = auth()->guard('usuario')->user();
        $id_empresa = $usuario->id_empresa;

        // Fetch tasks linked to harvests of this company
        $riego = \App\Models\Riego::whereHas('cosecha', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->with(['usuario', 'cosecha.semilla', 'tipoRiego'])->get();

        $insumoCosecha = \App\Models\InsumoCosecha::whereHas('cosecha', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->with(['usuario', 'cosecha.semilla', 'insumo'])->get();

        $recoleccion = \App\Models\Cultivo::whereHas('cosecha', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->with(['trabajador', 'cosecha.semilla'])->get();

        // Standardize descripcion and type for the view
        foreach ($riego as $t) {
            $t->tipo_referencia = 'riego';
            $t->descripcion = $t->tipoRiego?->tipo_riego ?? 'Riego';
            $t->sub_descripcion = $t->observaciones ?? null;
        }

        foreach ($insumoCosecha as $t) {
            $t->tipo_referencia = 'insumo';
            $insumoNombre = $t->insumo?->Nombre ?? 'Insumo';
            $cantidadLimpia = (float) ($t->cantidad_usada ?? 0);
            $t->descripcion = "Aplicación: " . $insumoNombre . " (" . $cantidadLimpia . ")";
            $t->sub_descripcion = $t->observaciones ?? null;
        }

        foreach ($recoleccion as $t) {
            $t->tipo_referencia = 'recoleccion';
            $t->descripcion = "RECOLECCIÓN"; // More consistent with the others
            $t->sub_descripcion = $t->descripcion_recoleccion ?? null;
            $t->fecha_programada = $t->fecha_recoleccion; // Alias for sorting
            // Map the relation 'trabajador' to 'usuario' to prevent errors in view
            $t->usuario = $t->trabajador;
        }

        // Fases general: fetch those linked to terrenos
        $general = \App\Models\FaseProgramada::whereHas('terreno', function ($q) use ($id_empresa) {
            $q->where('id_empresa', $id_empresa);
        })->with(['usuario', 'terreno'])
            ->get()
            ->map(function ($t) {
                $t->tipo_referencia = 'general';
                return $t;
            })
            ->reject(function ($t) {
                $desc = strtolower($t->descripcion);
                return str_contains($desc, 'riego') || str_contains($desc, 'insumo') || str_contains($desc, 'fertilizante') || str_contains($desc, 'fumigación') || str_contains($desc, 'abono');
            });

        // Terrenos Libres (without active harvest)
        $terrenosLibres = \App\Models\Terreno::where('id_empresa', $id_empresa)
            ->whereDoesntHave('cosechas', function ($q) {
                $q->where('id_estado', 1); // 1 = Activa/Pendiente? Assuming 1 is active based on previous findings
            })->get();

        // Dropdown data
        $trabajadores = \App\Models\Usuario::where('id_empresa', $id_empresa)
            ->where('id_tipo_usuario', 3)
            ->get();

        $cosechas = \App\Models\Cosecha::where('id_empresa', $id_empresa)
            ->with(['semilla', 'terreno'])
            ->get();

        $tiposRiego = \App\Models\TipoRiego::all();

        $catalogoInsumos = \App\Models\Insumo::where('id_empresa', $id_empresa)->get();

        return view('admin.tareas.index', compact('riego', 'insumoCosecha', 'recoleccion', 'general', 'trabajadores', 'cosechas', 'terrenosLibres', 'tiposRiego', 'catalogoInsumos'));
    }

    public function storeRiego(Request $request)
    {
        try {
            $request->validate([
                'id_cosecha' => 'required|exists:cosecha,id_cosecha',
                'documento_trabajador' => 'required|exists:usuario,documento',
                'id_tipo_riego' => 'required|exists:tipo_riego,id_tipo_riego',
                'cant_agua_apl' => 'required|numeric',
                'fecha_programada' => 'required|date',
                'observaciones' => 'nullable|string'
            ]);

            \App\Models\Riego::create([
                'id_cosecha' => $request->id_cosecha,
                'documento_trabajador' => $request->documento_trabajador,
                'id_tipo_riego' => $request->id_tipo_riego,
                'cant_agua_apl' => $request->cant_agua_apl,
                'fecha_programada' => $request->fecha_programada . ' ' . date('H:i:s'),
                'observaciones' => $request->observaciones ?? '',
                'id_estado' => 1
            ]);

            return redirect()->back()->with('success', 'Tarea de riego asignada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error en storeRiego: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error en base de datos: ' . $e->getMessage())->withInput();
        }
    }

    public function storeInsumo(Request $request)
    {
        try {
            $request->validate([
                'id_cosecha' => 'required|exists:cosecha,id_cosecha',
                'documento_trabajador' => 'required|exists:usuario,documento',
                'id_insumo' => 'required|exists:insumo,ID_insumo',
                'cantidad_usada' => 'required|numeric',
                'fecha_programada' => 'required|date',
                'observaciones' => 'nullable|string'
            ]);

            $insumo = \App\Models\Insumo::find($request->id_insumo);

            \App\Models\InsumoCosecha::create([
                'id_cosecha' => $request->id_cosecha,
                'documento_trabajador' => $request->documento_trabajador,
                'id_insumo' => $request->id_insumo,
                'cantidad_usada' => $request->cantidad_usada,
                'fecha_programada' => $request->fecha_programada . ' ' . date('H:i:s'),
                'observaciones' => $request->observaciones ?? '',
                'id_estado' => 1,
                'impacto_dias' => $insumo->impacto_dias ?? 0
            ]);

            return redirect()->back()->with('success', 'Tarea de insumo asignada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error en storeInsumo: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error en base de datos: ' . $e->getMessage())->withInput();
        }
    }

    public function storeGeneral(Request $request)
    {
        try {
            $request->validate([
                'descripcion' => 'required|string|max:255',
                'id_terreno' => 'required|exists:terreno,id_terreno',
                'documento_trabajador' => 'required|exists:usuario,documento',
                'fecha_programada' => 'required|date'
            ]);

            \App\Models\FaseProgramada::create([
                'descripcion' => $request->descripcion,
                'fecha_programada' => $request->fecha_programada . ' ' . date('H:i:s'),
                'id_estado' => 1,
                'id_terreno' => $request->id_terreno,
                'documento_trabajador' => $request->documento_trabajador
            ]);

            return redirect()->back()->with('success', 'Nueva labor general asignada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error en storeGeneral: " . $e->getMessage());
            return redirect()->back()->with('error', 'Error en base de datos: ' . $e->getMessage())->withInput();
        }
    }

    public function trabajadorCalendario()
    {
        return view('trabajadores.calendario');
    }

    public function getEventosCalendario()
    {
        $usuario = auth()->guard('usuario')->user();
        if (!$usuario)
            return response()->json([]);

        $eventos = [];

        // 0. Asistencias (Registros del trabajador)
        // Excepto las que son tareas ocultas/omitidas
        $asistencias = \App\Models\RegistroTrabajo::where('documento_trabajador', $usuario->documento)
            ->where('observacion', '!=', 'Tarea perdida ocultada por el trabajador.')
            ->get();
        foreach ($asistencias as $asist) {
            $isLinked = $asist->id_fase || $asist->id_riego || $asist->id_insumo_cosecha || $asist->id_cultivo;
            if ($isLinked) {
                // Ya no mostramos la tarjeta genérica "Asistencia Confirmada"
                // si el registro pertenece a una labor específica.
                continue;
            }
            $eventos[] = [
                'id' => 'registro_' . $asist->id_registro_trabajo,
                'title' => 'Asistencia Confirmada',
                'start' => date('Y-m-d', strtotime($asist->fecha_trabajada)),
                'color' => '#10b981', // Verde esmeralda
                'extendedProps' => [
                    'tipo' => 'registro',
                    'observacion' => $asist->observacion,
                    'foto_url' => $asist->foto_evidencia ? asset('uploads/' . $asist->foto_evidencia) : null,
                    'estado' => 15
                ]
            ];
        }

        // Fetch observations for lookup
        $registros = \Illuminate\Support\Facades\DB::table('registro_trabajo')
            ->where('documento_trabajador', $usuario->documento)
            ->get();

        $obsFase = $registros->whereNotNull('id_fase')->pluck('observacion', 'id_fase')->toArray();
        $obsRiego = $registros->whereNotNull('id_riego')->pluck('observacion', 'id_riego')->toArray();
        $obsInsumo = $registros->whereNotNull('id_insumo_cosecha')->pluck('observacion', 'id_insumo_cosecha')->toArray();
        $obsRecoleccion = $registros->whereNotNull('id_cultivo')->pluck('observacion', 'id_cultivo')->toArray();

        $fotoFase = $registros->whereNotNull('id_fase')->pluck('foto_evidencia', 'id_fase')->toArray();
        $fotoRiego = $registros->whereNotNull('id_riego')->pluck('foto_evidencia', 'id_riego')->toArray();
        $fotoInsumo = $registros->whereNotNull('id_insumo_cosecha')->pluck('foto_evidencia', 'id_insumo_cosecha')->toArray();
        $fotoRecoleccion = $registros->whereNotNull('id_cultivo')->pluck('foto_evidencia', 'id_cultivo')->toArray();

        // 1. Fase Programada
        $fases = \App\Models\FaseProgramada::with(['terreno'])
            ->where('documento_trabajador', $usuario->documento)
            ->get();
        foreach ($fases as $fase) {
            $nombreLugar = $fase->terreno ? $fase->terreno->nombre : 'Terreno';

            $color = match ((int) $fase->id_estado) {
                15 => '#10b981',
                17 => '#f59e0b',
                16, 18 => '#ef4444',
                default => '#3b82f6'
            };

            $eventos[] = [
                'id' => $fase->id_fase,
                'title' => strtoupper($fase->descripcion) . " - " . $nombreLugar,
                'start' => $fase->fecha_programada,
                'color' => $color,
                'extendedProps' => [
                    'tipo' => 'fase',
                    'descripcion' => $fase->descripcion,
                    'cultivo' => $nombreLugar,
                    'estado' => $fase->id_estado,
                    'foto_url' => isset($fotoFase[$fase->id_fase]) && $fotoFase[$fase->id_fase] ? asset('uploads/' . $fotoFase[$fase->id_fase]) : null,
                    'observacion' => $obsFase[$fase->id_fase] ?? null
                ]
            ];
        }

        // 2. Riego
        $riegos = \App\Models\Riego::with(['cosecha.terreno', 'cosecha.semilla'])->where('documento_trabajador', $usuario->documento)->get();
        foreach ($riegos as $riego) {
            $nombreLugar = $riego->cosecha && $riego->cosecha->terreno ? $riego->cosecha->terreno->nombre : 'Terreno';

            $color = match ((int) $riego->id_estado) {
                15 => '#0ea5e9', // Mantener color del riego (azul)
                17 => '#f59e0b',
                16, 18 => '#ef4444',
                default => '#0ea5e9'
            };

            $eventos[] = [
                'id' => 'riego_' . $riego->id_riego,
                'title' => 'RIEGO - ' . $nombreLugar,
                'start' => $riego->fecha_programada,
                'color' => $color,
                'extendedProps' => [
                    'tipo' => 'riego',
                    'descripcion' => $riego->observaciones,
                    'estado' => $riego->id_estado,
                    'parcela' => $riego->cosecha?->terreno?->nombre,
                    'variedad' => $riego->cosecha?->semilla?->nombre_semilla,
                    'foto_url' => isset($fotoRiego[$riego->id_riego]) && $fotoRiego[$riego->id_riego] ? asset('uploads/' . $fotoRiego[$riego->id_riego]) : null,
                    'observacion' => $obsRiego[$riego->id_riego] ?? $riego->observaciones
                ]
            ];
        }

        // 3. Insumos
        $insumos = \App\Models\InsumoCosecha::with(['insumo', 'cosecha.terreno', 'cosecha.semilla'])->where('documento_trabajador', $usuario->documento)->get();
        foreach ($insumos as $insumo) {
            $nombreLugar = $insumo->cosecha && $insumo->cosecha->terreno ? $insumo->cosecha->terreno->nombre : 'Terreno';

            $color = match ((int) $insumo->id_estado) {
                15 => '#8b5cf6', // Mantener color del insumo (morado)
                17 => '#f59e0b',
                16, 18 => '#ef4444',
                default => '#8b5cf6'
            };

            $unidad = $insumo->insumo?->Unidad_Medida ?? 'unidades';
            $cantidadLimpia = (float) $insumo->cantidad_usada;
            $cantidadText = $cantidadLimpia > 0 ? " (Usar: {$cantidadLimpia} {$unidad})" : '';

            $eventos[] = [
                'id' => 'insumo_' . $insumo->id_insumo_cosecha,
                'title' => 'INSUMO - ' . $nombreLugar,
                'start' => $insumo->fecha_programada,
                'color' => $color,
                'extendedProps' => [
                    'tipo' => 'insumo',
                    'descripcion' => 'Aplicación de Insumo: ' . ($insumo->insumo?->Nombre ?? 'Desconocido') . $cantidadText,
                    'estado' => $insumo->id_estado,
                    'parcela' => $insumo->cosecha?->terreno?->nombre,
                    'variedad' => $insumo->cosecha?->semilla?->nombre_semilla,
                    'foto_url' => isset($fotoInsumo[$insumo->id_insumo_cosecha]) && $fotoInsumo[$insumo->id_insumo_cosecha] ? asset('uploads/' . $fotoInsumo[$insumo->id_insumo_cosecha]) : null,
                    'observacion' => $obsInsumo[$insumo->id_insumo_cosecha] ?? null
                ]
            ];
        }

        // 4. Recoleccion
        $recolecciones = \App\Models\Cultivo::with(['cosecha.terreno', 'cosecha.semilla', 'detalles.producto'])->where('documento_trabajador', $usuario->documento)->get();
        foreach ($recolecciones as $reco) {
            $nombreLugar = $reco->cosecha && $reco->cosecha->terreno ? $reco->cosecha->terreno->nombre : 'Terreno';

            $color = match ((int) $reco->id_estado) {
                15 => '#f97316', // Mantener color naranja
                17 => '#f59e0b',
                16, 18 => '#ef4444',
                default => '#f97316'
            };

            $eventos[] = [
                'id' => 'recoleccion_' . $reco->id_cultivo,
                'title' => 'RECOLECCIÓN - ' . $nombreLugar,
                'start' => ($reco->fecha_programada ?? $reco->fecha_recoleccion) . ' 08:00:00',
                'color' => $color,
                'allDay' => false,
                'extendedProps' => [
                    'tipo' => 'recoleccion',
                    'descripcion' => $reco->descripcion_recoleccion,
                    'estado' => $reco->id_estado,
                    'parcela' => $reco->cosecha?->terreno?->nombre,
                    'variedad' => $reco->cosecha?->semilla?->nombre_semilla,
                    'cantidad' => $reco->detalles->sum('cantidad'),
                    'calidad' => $reco->detalles->first()?->calidad,
                    'foto_url' => isset($fotoRecoleccion[$reco->id_cultivo]) && $fotoRecoleccion[$reco->id_cultivo] ? asset('uploads/' . $fotoRecoleccion[$reco->id_cultivo]) : null,
                    'observacion' => $obsRecoleccion[$reco->id_cultivo] ?? $reco->descripcion_recoleccion
                ]
            ];
        }

        return response()->json($eventos);
    }


    public function storeRegistroTrabajo(Request $request)
    {
        $usuario = auth()->guard('usuario')->user();

        $request->validate([
            'fecha_trabajada' => 'required|date|after_or_equal:today',
            'observacion' => 'nullable|string|max:500',
            'foto_evidencia' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ], [
            'fecha_trabajada.after_or_equal' => 'No puedes registrar trabajo para días anteriores.'
        ]);

        // Verificar si ya registró ese día
        $existe = \App\Models\RegistroTrabajo::where('documento_trabajador', $usuario->documento)
            ->where('fecha_trabajada', $request->fecha_trabajada)
            ->exists();

        if ($existe) {
            return response()->json(['error' => 'Ya has registrado trabajo para este día.'], 422);
        }

        $imagePath = null;
        if ($request->hasFile('foto_evidencia')) {
            $imagePath = $request->file('foto_evidencia')->store('evidencias', 'public');
        }

        \App\Models\RegistroTrabajo::create([
            'documento_trabajador' => $usuario->documento,
            'fecha_trabajada' => $request->fecha_trabajada,
            'observacion' => $request->observacion,
            'id_insumo_cosecha' => $request->id_insumo_cosecha ?? null,
            'id_estado' => '1',
            'foto_evidencia' => $imagePath
        ]);

        return response()->json(['success' => 'Día de trabajo registrado correctamente.']);
    }

    public function trabajadorPagos()
    {
        $usuario = auth()->guard('usuario')->user();

        $pagos = \App\Models\Salario::with('tipoSalario')
            ->where('documento_trabajador', $usuario->documento)
            ->orderBy('fecha_pago', 'desc')
            ->get();

        return view('trabajadores.mis_pagos', compact('pagos'));
    }

    // --- MÉTODOS DE SOPORTE ---

    public function soporteTrabajador()
    {
        $usuario = auth()->guard('usuario')->user();
        $mensajes = \App\Models\Soporte::where('documento_trabajador', $usuario->documento)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('trabajadores.soporte', compact('mensajes', 'usuario'));
    }

    public function storeSoporte(Request $request)
    {
        $usuario = auth()->guard('usuario')->user();

        $request->validate([
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string'
        ]);

        \App\Models\Soporte::create([
            'documento_trabajador' => $usuario->documento,
            'id_empresa' => $usuario->id_empresa,
            'asunto' => $request->asunto,
            'mensaje' => $request->mensaje,
            'estado' => 'Pendiente'
        ]);

        return redirect()->back()->with('success', 'Tu mensaje ha sido enviado al administrador.');
    }

    public function adminSoporte()
    {
        $admin = auth()->guard('usuario')->user();

        $mensajes = \App\Models\Soporte::with('trabajador')
            ->where('id_empresa', $admin->id_empresa)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.soporte.index', compact('mensajes'));
    }

    public function responderSoporte(Request $request, $id)
    {
        $admin = auth()->guard('usuario')->user();

        $mensaje = \App\Models\Soporte::where('id_soporte', $id)
            ->where('id_empresa', $admin->id_empresa)
            ->firstOrFail();

        $request->validate([
            'respuesta' => 'required|string'
        ]);

        $mensaje->update([
            'respuesta' => $request->respuesta,
            'estado' => 'Respondido'
        ]);

        return redirect()->back()->with('success', 'Respuesta enviada correctamente.');
    }
}
