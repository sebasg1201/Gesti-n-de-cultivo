<?php

namespace App\Services;

use App\Models\Cosecha;
use App\Models\Riego;
use App\Models\Insumo;
use App\Models\InsumoCosecha;
use App\Models\FaseProgramada;
use App\Models\Cultivo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function getNotifications()
    {
        $user = Auth::guard('usuario')->user();
        if (!$user) return [];

        $id_empresa = $user->id_empresa;
        $isWorker = in_array($user->id_tipo_usuario, [2, 3]); // Supervisor o Trabajador
        $workerDoc = $isWorker ? $user->documento : null;

        $notifications = [];

        // 1. Irrigation Alerts
        $irrigationAlerts = $this->getIrrigationAlerts($id_empresa, $workerDoc);
        $hoy = Carbon::now();

        foreach ($irrigationAlerts as $alert) {
            $nextDate = Carbon::parse($alert->next_date);
            $diffHours = $hoy->diffInHours($nextDate, false);
            
            // Si es trabajador, solo mostrar si falta menos de 24h para vencer o ya venció
            if ($isWorker && $diffHours > 24) continue;

            $title = ($isWorker && $diffHours <= 24 && $diffHours > 0) 
                ? 'Tiempo por vencer: Riego pronto' 
                : 'Necesita Riego';

            $notifications[] = [
                'type' => 'irrigation',
                'title' => $title,
                'message' => "El cultivo de {$alert->semilla->nombre_semilla} en el terreno {$alert->terreno->nombre} necesita ser regado.",
                'date' => $nextDate,
                'id' => $alert->id_cosecha,
                'url' => route($isWorker ? 'trabajador.dashboard' : 'admin.tareas.index', $isWorker ? ['task_id' => $alert->id_cosecha, 'task_type' => 'riego'] : [])
            ];
        }

        // 2. Stock Alerts (Only for Admin)
        if (!$isWorker) {
            $stockAlerts = Insumo::where('id_empresa', $id_empresa)
                ->where('stock_actual', '<', 10)
                ->get();
            
            foreach ($stockAlerts as $insumo) {
                $notifications[] = [
                    'type' => 'stock',
                    'title' => 'Stock Bajo',
                    'message' => "El insumo '{$insumo->Nombre}' tiene un stock crítico de {$insumo->stock_actual}.",
                    'date' => $insumo->updated_at ?? ($insumo->created_at ?? Carbon::now()->subMinutes(5)),
                    'id' => $insumo->ID_insumo,
                    'url' => route('admin.proveedores.index')
                ];

            }
        }

        // 3. Insecticide Alerts
        $insecticideAlerts = $this->getInsecticideAlerts($id_empresa, $workerDoc);
        foreach ($insecticideAlerts as $alert) {
            $nextDate = Carbon::parse($alert->next_date);
            $diffHours = $hoy->diffInHours($nextDate, false);

            if ($isWorker && $diffHours > 24) continue;

            $title = ($isWorker && $diffHours <= 24 && $diffHours > 0) 
                ? 'Tiempo por vencer: Insecticida' 
                : 'Aplicación de Insecticida';

            $notifications[] = [
                'type' => 'insecticide',
                'title' => $title,
                'message' => "Es necesario aplicar insecticida al cultivo de {$alert->semilla->nombre_semilla} ({$alert->terreno->nombre}).",
                'date' => $nextDate,
                'id' => $alert->id_cosecha,
                'url' => route($isWorker ? 'trabajador.dashboard' : 'admin.tareas.index', $isWorker ? ['task_id' => $alert->id_cosecha, 'task_type' => 'insumo'] : [])
            ];
        }
        
        // 4. Personal Task Alerts (Scheduled Tasks)
        if ($isWorker) {
            $taskAlerts = $this->getPersonalTaskAlerts($workerDoc);
            foreach ($taskAlerts as $task) {
                $notifications[] = [
                    'type' => $task['type'],
                    'title' => $task['title'],
                    'message' => $task['message'],
                    'date' => $task['date'],
                    'id' => $task['id'],
                    'url' => route('trabajador.dashboard', ['task_id' => $task['id'], 'task_type' => $task['type']])
                ];
            }
        }

        // Sort by date desc
        usort($notifications, function($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        return $notifications;
    }

    private function getIrrigationAlerts($id_empresa, $workerDoc = null)
    {
        $query = Cosecha::query()->with(['terreno.tipoSuelo', 'semilla'])
            ->where('id_empresa', $id_empresa)
            ->whereIn('id_estado', [1, 3]); // Pendiente o Activa
        
        if ($workerDoc) {
            $query->where(function($q) use ($workerDoc) {
                $q->whereIn('id_cosecha', function($sq) use ($workerDoc) {
                    $sq->select('id_cosecha')->from('riego')->where('documento_trabajador', $workerDoc);
                })->orWhereIn('id_cosecha', function($sq) use ($workerDoc) {
                    $sq->select('id_cosecha')->from('insumo_cosecha')->where('documento_trabajador', $workerDoc);
                });
            });
        }

        $cosechas = $query->get();
        $alerts = [];
        $hoy = Carbon::now();

        foreach ($cosechas as $cosecha) {
            $ultimoRiego = Riego::where('id_cosecha', $cosecha->id_cosecha)
                ->where('id_estado', 15) // Realizado
                ->orderBy('fecha_programada', 'desc')
                ->first();

            $fechaBase = $ultimoRiego ? Carbon::parse($ultimoRiego->fecha_programada) : Carbon::parse($cosecha->fecha_siembra);
            
            $frecuencia = 2; // Default
            $suelo = $cosecha->terreno->tipoSuelo->nombre ?? '';
            
            if (stripos($suelo, 'Arenoso') !== false) {
                $frecuencia = 5;
            } elseif (stripos($suelo, 'Arcilloso') !== false) {
                $frecuencia = 10;
            } else {
                $frecuencia = $cosecha->frecuencia_riego_dias ?: 3;
            }

            $proximaFecha = $fechaBase->addDays($frecuencia);

            // Ajuste para el trabajador: mostrar si faltan 24h o ya venció
            if ($hoy->diffInHours($proximaFecha, false) <= 24) {
                $cosecha->next_date = $proximaFecha;
                $alerts[] = $cosecha;
            }
        }

        return $alerts;
    }

    private function getInsecticideAlerts($id_empresa, $workerDoc = null)
    {
        $query = Cosecha::query()->with(['terreno', 'semilla'])
            ->where('id_empresa', $id_empresa)
            ->whereIn('id_estado', [1, 3]); // Pendiente o Activa

        if ($workerDoc) {
            $query->where(function($q) use ($workerDoc) {
                $q->whereIn('id_cosecha', function($sq) use ($workerDoc) {
                    $sq->select('id_cosecha')->from('riego')->where('documento_trabajador', $workerDoc);
                })->orWhereIn('id_cosecha', function($sq) use ($workerDoc) {
                    $sq->select('id_cosecha')->from('insumo_cosecha')->where('documento_trabajador', $workerDoc);
                });
            });
        }

        $cosechas = $query->get();
        $alerts = [];
        $hoy = Carbon::now();

        foreach ($cosechas as $cosecha) {
            $ultimaAplicacion = InsumoCosecha::where('id_cosecha', $cosecha->id_cosecha)
                ->whereHas('insumo.catalogo', function($q) {
                    $q->where('id_tipo_insumo', 10); // Pesticida
                })
                ->where('id_estado', 15) // Realizado
                ->orderBy('fecha_programada', 'desc')
                ->first();

            $fechaBase = $ultimaAplicacion ? Carbon::parse($ultimaAplicacion->fecha_programada) : Carbon::parse($cosecha->fecha_siembra);
            $proximaFecha = $fechaBase->addDays(10);

            if ($hoy->diffInHours($proximaFecha, false) <= 24) {
                $cosecha->next_date = $proximaFecha;
                $alerts[] = $cosecha;
            }
        }

        return $alerts;
    }
    
    private function getPersonalTaskAlerts($workerDoc)
    {
        $alerts = [];
        $hoy = Carbon::today();
        
        // Fases Programadas
        $fases = FaseProgramada::where('documento_trabajador', $workerDoc)
            ->whereIn('id_estado', [1, 16, 17]) // Pendiente, Perdida, En Proceso
            ->get();
            
        foreach ($fases as $fase) {
            $this->processGenericTask($fase, 'fase', $alerts, $hoy);
        }
        
        // Riegos Programados
        $riegos = Riego::where('documento_trabajador', $workerDoc)
            ->whereIn('id_estado', [1, 16, 17])
            ->get();
            
        foreach ($riegos as $riego) {
            $this->processGenericTask($riego, 'riego', $alerts, $hoy);
        }
        
        // Insumos Programados
        $insumos = InsumoCosecha::where('documento_trabajador', $workerDoc)
            ->whereIn('id_estado', [1, 16, 17])
            ->get();
            
        foreach ($insumos as $insumo) {
            $this->processGenericTask($insumo, 'insumo', $alerts, $hoy);
        }
        
        // Recolecciones
        $recolecciones = Cultivo::where('documento_trabajador', $workerDoc)
            ->whereIn('id_estado', [1, 16, 17])
            ->get();
            
        foreach ($recolecciones as $reco) {
            // Mapping fecha_recoleccion to fecha_programada for standard processing
            if ($reco->fecha_recoleccion && !$reco->fecha_programada) {
                $reco->fecha_programada = $reco->fecha_recoleccion;
            }
            $this->processGenericTask($reco, 'recoleccion', $alerts, $hoy);
        }
        
        return $alerts;
    }
    
    private function processGenericTask($task, $type, &$alerts, $hoy)
    {
        if (!$task->fecha_programada) return;
        
        $fecha = Carbon::parse($task->fecha_programada);
        $isToday = $fecha->isToday();
        $isLost = ($task->id_estado == 16) || (!$isToday && $fecha->isPast() && $task->id_estado == 1);
        
        if ($isToday || $isLost) {
            $title = $isLost ? '¡Tarea Perdida/Pendiente!' : 'Tarea para Hoy';
            $desc = $task->descripcion ?? ($task->observaciones ?? 'Actividad programada');
            
            $alerts[] = [
                'type' => $type,
                'title' => $title,
                'message' => "Tienes una tarea: " . substr($desc, 0, 50) . ($desc && strlen($desc) > 50 ? "..." : ""),
                'date' => $fecha,
                'id' => $task->getKey(),
            ];
        }
    }
}
