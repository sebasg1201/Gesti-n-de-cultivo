<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cosecha;
use App\Models\Riego;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GenerarRiegos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generar-riegos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera tareas de riego para las cosechas activas basándose en su frecuencia de riego';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoy = Carbon::today();
        
        // Obtener cosechas activas (id_estado = 1) que no han pasado su fecha estimada
        $cosechas = Cosecha::where('id_estado', 1)
            ->whereNotNull('fecha_estimada')
            ->whereDate('fecha_estimada', '>=', $hoy)
            ->get();
            
        $this->info("Encontradas {$cosechas->count()} cosechas activas.");

        foreach ($cosechas as $cosecha) {
            $fechaSiembra = Carbon::parse($cosecha->fecha_siembra)->startOfDay();
            $diasTranscurridos = $fechaSiembra->diffInDays($hoy, false);

            // Si aún no es tiempo de empezar, o no ha transcurrido ningún día (el día 0 se crea al momento de registrar)
            if ($diasTranscurridos <= 0) {
                continue;
            }

            // Verificar si hoy toca riego basado en la frecuencia
            if ($cosecha->frecuencia_riego_dias > 0 && ($diasTranscurridos % $cosecha->frecuencia_riego_dias) == 0) {
                $this->info("Generando riego para cosecha ID {$cosecha->id_cosecha}");
                $this->generarRiegoParaCosecha($cosecha, $hoy);
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
            Log::warning("No se encontró riego previo para la cosecha {$cosecha->id_cosecha}");
            return;
        }

        // Ya existe un riego programado para hoy?
        $existeHoy = Riego::where('id_cosecha', $cosecha->id_cosecha)
            ->whereDate('fecha_programada', $fecha)
            ->exists();
            
        if ($existeHoy) {
            return;
        }

        // Selección del "Pool" de Trabajadores
        $trabajadores = Usuario::where('id_empresa', $cosecha->id_empresa)
            ->where('id_tipo_usuario', 3) // trabajador
            ->where('id_estado', 1)       // Activo
            ->where('id_estado_trabajador', 1)  // Disponible
            ->get();
            
        $trabajadoresCount = $trabajadores->count();
        $cargasTrabajo = [];
        $id_asignado = null;
        
        if ($trabajadoresCount > 0) {
            foreach ($trabajadores as $t) {
                $cargasTrabajo[$t->documento] = Riego::where('documento_trabajador', $t->documento)
                    ->where('id_estado', 1) // Pendiente
                    ->count();
            }
            asort($cargasTrabajo);
            reset($cargasTrabajo);
            $id_asignado = key($cargasTrabajo);
        } else {
            // Reusar el trabajador del último riego
            $id_asignado = $ultimoRiego->documento_trabajador;
        }

        // Usamos la fecha programada pero le ponemos la hora actual para que no quede en 00:00:00
        $fechaProgramadaHora = $fecha->copy()->setTimeFrom(\Carbon\Carbon::now());
        
        Riego::create([
            'cant_agua_apl' => $cosecha->litros_por_riego,
            'id_tipo_riego' => $ultimoRiego->id_tipo_riego,
            'id_cosecha' => $cosecha->id_cosecha,
            'documento_trabajador' => $id_asignado,
            'id_estado' => 1, // Pendiente
            'fecha_programada' => $fechaProgramadaHora->format('Y-m-d H:i:s')
        ]);
    }
}
