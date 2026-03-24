<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cosecha;
use App\Models\Riego;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerarRiegos extends Command
{
    protected $signature = 'app:generar-riegos';
    protected $description = 'Genera tareas de riego para las cosechas activas y marca como perdida los riegos no completados a tiempo';

    public function handle()
    {
        $hoy = Carbon::today();

        // ====================================================
        // 1. Riegos
        $riegosPerdidos = DB::table('riego')->whereIn('id_estado', [1, 17])
            ->whereDate('fecha_programada', '<', $hoy)
            ->get();

        foreach ($riegosPerdidos as $riego) {
            DB::table('riego')->where('id_riego', $riego->id_riego)->update(['id_estado' => 16]);
            $cosecha = Cosecha::find($riego->id_cosecha);
            if ($cosecha && $cosecha->fecha_estimada) {
                $nuevaFecha = Carbon::parse($cosecha->fecha_estimada)->addDays(2);
                DB::table('cosecha')->where('id_cosecha', $cosecha->id_cosecha)->update(['fecha_estimada' => $nuevaFecha->format('Y-m-d')]);
                Log::info("Riego #{$riego->id_riego} marcado como Perdida. Cosecha #{$cosecha->id_cosecha} extendida 2 días.");
            }
        }

        // 2. Fases Programadas
        $fasesPerdidas = DB::table('fases_programadas')->whereIn('id_estado', [1, 17])
            ->whereDate('fecha_programada', '<', $hoy)
            ->update(['id_estado' => 16]);

        // 3. Insumos
        $insumosPerdidos = DB::table('insumo_cosecha')->whereIn('id_estado', [1, 17])
            ->whereDate('fecha_programada', '<', $hoy)
            ->update(['id_estado' => 16]);

        $this->info("Riegos perdidos: " . count($riegosPerdidos) . ", Fases perdidas: $fasesPerdidas, Insumos perdidos: $insumosPerdidos");

        // ====================================================
        // PASO 2: Generar nuevas tareas de riego para hoy
        // ====================================================
        $cosechas = Cosecha::where('id_estado', 1)
            ->whereNotNull('fecha_estimada')
            ->whereDate('fecha_estimada', '>=', $hoy)
            ->get();

        $this->info("Cosechas activas encontradas: {$cosechas->count()}");

        foreach ($cosechas as $cosecha) {
            $fechaSiembra = Carbon::parse($cosecha->fecha_siembra)->startOfDay();
            $diasTranscurridos = $fechaSiembra->diffInDays($hoy, false);

            if ($diasTranscurridos <= 0) {
                continue;
            }

            // En lugar de chequear solo el mod de hoy, encontramos el último riego registrado
            $ultimoRiego = Riego::where('id_cosecha', $cosecha->id_cosecha)
                ->orderBy('fecha_programada', 'desc')
                ->first();

            if ($ultimoRiego) {
                $fechaUltimoRiego = Carbon::parse($ultimoRiego->fecha_programada)->startOfDay();
                
                // Si la frecuencia es mayor a 0, calculamos los días faltantes
                $frecuencia = $cosecha->frecuencia_riego_dias;
                if ($frecuencia > 0) {
                    $fechaIteracion = $fechaUltimoRiego->copy()->addDays($frecuencia);
                    
                    // Genera todos los riegos faltantes desde el último hasta hoy
                    while ($fechaIteracion <= $hoy) {
                        $this->info("Generando riego recuperado/programado para cosecha #{$cosecha->id_cosecha} del día {$fechaIteracion->format('Y-m-d')}");
                        $this->generarRiegoParaCosecha($cosecha, $fechaIteracion);
                        $fechaIteracion->addDays($frecuencia);
                    }
                }
            } else {
                // Failsafe por si no hay un último riego (solo debería pasar si se borró de la BD manualmente)
                if ($cosecha->frecuencia_riego_dias > 0 && ($diasTranscurridos % $cosecha->frecuencia_riego_dias) == 0) {
                    $this->info("Generando riego para cosecha #{$cosecha->id_cosecha}");
                    $this->generarRiegoParaCosecha($cosecha, $hoy);
                }
            }
        }

        $this->info('Proceso de generación de riegos finalizado.');
    }

    private function generarRiegoParaCosecha($cosecha, $fecha)
    {
        $ultimoRiego = Riego::where('id_cosecha', $cosecha->id_cosecha)
            ->orderBy('id_riego', 'desc')
            ->first();

        if (!$ultimoRiego) {
            Log::warning("No se encontró riego previo para la cosecha #{$cosecha->id_cosecha}");
            return;
        }

        // ¿Ya existe un riego programado para hoy?
        $existeHoy = Riego::where('id_cosecha', $cosecha->id_cosecha)
            ->whereDate('fecha_programada', $fecha)
            ->exists();

        if ($existeHoy) {
            return;
        }

        // === Selección del trabajador con menos carga ===
        // Solo TRABAJADORES (id_tipo_usuario=3) de la empresa
        $queryT = Usuario::where('id_empresa', $cosecha->id_empresa)
            ->where('id_tipo_usuario', 3);

        // Prioridad 1: activo y disponible
        $trabajadores = (clone $queryT)->where('id_estado', 1)->where('id_estado_trabajador', 1)->get();
        // Prioridad 2: cualquier activo
        if ($trabajadores->isEmpty()) {
            $trabajadores = (clone $queryT)->where('id_estado', 1)->get();
        }
        // Prioridad 3: cualquier trabajador
        if ($trabajadores->isEmpty()) {
            $trabajadores = $queryT->get();
        }

        $id_asignado = null;

        if ($trabajadores->isNotEmpty()) {
            $cargas = [];
            foreach ($trabajadores as $t) {
                $cargas[$t->documento] = Riego::where('documento_trabajador', $t->documento)
                    ->whereIn('id_estado', [1, 17]) // Pendiente + En Proceso
                    ->count();
            }
            asort($cargas);
            reset($cargas);
            $id_asignado = key($cargas);
        } else {
            // Sin trabajadores: reusar al del último riego
            $id_asignado = $ultimoRiego->documento_trabajador;
            Log::warning("Sin trabajadores disponibles para cosecha #{$cosecha->id_cosecha}. Reutilizando trabajador #{$id_asignado}");
        }

        $fechaProgramadaHora = $fecha->copy()->setTimeFrom(Carbon::now());

        $id_estado = $fecha->lt(Carbon::today()) ? 16 : 1;

        Riego::create([
            'cant_agua_apl'        => $cosecha->litros_por_riego,
            'id_tipo_riego'        => $ultimoRiego->id_tipo_riego,
            'id_cosecha'           => $cosecha->id_cosecha,
            'documento_trabajador' => $id_asignado,
            'id_estado'            => $id_estado,
            'fecha_programada'     => $fechaProgramadaHora->format('Y-m-d H:i:s'),
            'observaciones'        => "Aplicar {$cosecha->litros_por_riego}L - Riego programado automáticamente.",
        ]);

        if ($id_estado == 16 && $cosecha->fecha_estimada) {
            $nuevaFecha = Carbon::parse($cosecha->fecha_estimada)->addDays(2);
            $cosecha->update(['fecha_estimada' => $nuevaFecha->format('Y-m-d')]);
        }

        Log::info("Riego creado para cosecha #{$cosecha->id_cosecha} → trabajador #{$id_asignado} para {$fechaProgramadaHora->format('Y-m-d')} (Estado: {$id_estado})");
    }
}
