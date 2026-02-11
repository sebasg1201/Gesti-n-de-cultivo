<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\VentaLicencias;
use App\Models\Empresa;
use Carbon\Carbon;

class CheckLicenseExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-license-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired licenses and block associated companies';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired licenses...');
        
        // Find ACTIVE licenses (id_estado = 3)
        // Seeder confirms 3 is Active.
        
        $activeLicenses = VentaLicencias::where('id_estado', 3)->with(['tipoLicencia', 'empresa'])->get();
        $expiredCount = 0;

        foreach ($activeLicenses as $license) {
            $tipo = $license->tipoLicencia;
            if (!$tipo) continue;

            $meses = (int) filter_var($tipo->tiempo, FILTER_SANITIZE_NUMBER_INT);
            if ($meses == 0) $meses = 12;

            $fechaInicio = Carbon::parse($license->fecha_inicio);
            $fechaFin = $fechaInicio->copy()->addMonths($meses);

            if ($fechaFin->isPast()) {
                // License expired
                $this->warn("License for company {$license->id_empresa} expired on {$fechaFin->toDateString()}. Blocking company...");

                // Update license status
                $license->id_estado = 2; // Expired/Inactive
                $license->save();

                // Block company
                if ($license->empresa) {
                    $license->empresa->id_estado = 2; // Blocked
                    $license->empresa->save();
                }

                $expiredCount++;
            }
        }

        $this->info("Done. {$expiredCount} licenses expired and companies blocked.");
    }
}
