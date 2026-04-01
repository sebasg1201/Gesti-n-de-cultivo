<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cosecha;
use App\Models\FaseProgramada;

echo "--- TEST DE ACTIVACION ---\n";
$fase = FaseProgramada::where('id_fase', 8)->first(); // La que sale en el debug anterior
$cosecha = Cosecha::where('id_terreno', $fase->id_terreno)->where('id_estado', 10)->first();

if (!$cosecha) {
    die("No se encontro cosecha para el terreno {$fase->id_terreno} con estado 10\n");
}

echo "Cosecha encontrada ID: {$cosecha->id_cosecha}\n";
echo "Desc Fase: '{$fase->descripcion}'\n";

$is_siembra = (str_contains($fase->descripcion, '[INICIO_RIEGO:') || str_contains(strtolower($fase->descripcion), 'siembra'));
echo "¿Es siembra según lógica?: " . ($is_siembra ? 'SI' : 'NO') . "\n";

if ($is_siembra) {
    try {
        echo "Actualizando cosecha...\n";
        $cosecha->update(['id_estado' => 1]);
        echo "Estado cosecha ahora: {$cosecha->id_estado}\n";
        
        $riegoId = 1;
        if (preg_match('/\[TIPO_RIEGO:(\d+)\]/', $fase->descripcion, $matches)) {
            $riegoId = $matches[1];
        }
        
        $fechaInicioRiego = null;
        if (preg_match('/\[INICIO_RIEGO:([\d-]+)\]/', $fase->descripcion, $dateMatches)) {
            $fechaInicioRiego = $dateMatches[1];
        }
        
        echo "Riego ID detectado: $riegoId | Fecha Inicio: ".($fechaInicioRiego ?? 'Null')."\n";
        
        // Simular creación de riego
        $fechaProgramada = $fechaInicioRiego ? \Carbon\Carbon::parse($fechaInicioRiego) : \Carbon\Carbon::now();
        echo "Fecha Programada Riego: ".$fechaProgramada->toDateTimeString()."\n";
        
    } catch (\Exception $e) {
        echo "ERROR DURANTE ACTIVACION: " . $e->getMessage() . "\n";
    }
}
