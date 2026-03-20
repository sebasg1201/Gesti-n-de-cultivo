<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Riego;
use App\Models\Cosecha;
use Carbon\Carbon;

$hoy = Carbon::today();
echo "Hoy: " . $hoy->toDateString() . "\n";

echo "--- Riegos pendientes/en proceso anteriores a hoy ---\n";
$perdidosPotenciales = Riego::whereIn('id_estado', [1, 17])
    ->whereDate('fecha_programada', '<', $hoy)
    ->get();
foreach ($perdidosPotenciales as $r) {
    echo "ID: {$r->id_riego}, Fecha: {$r->fecha_programada}, Estado: {$r->id_estado}, Cosecha: {$r->id_cosecha}\n";
}

echo "\n--- Cosechas activas (id_estado=1) ---\n";
$cosechas = Cosecha::where('id_estado', 1)->get();
foreach ($cosechas as $c) {
    echo "ID: {$c->id_cosecha}, Siembra: {$c->fecha_siembra}, Estimada: {$c->fecha_estimada}, Frecuencia: {$c->frecuencia_riego_dias}\n";
    
    $ultimo = Riego::where('id_cosecha', $c->id_cosecha)->orderBy('fecha_programada', 'desc')->first();
    if ($ultimo) {
        echo "  Último Riego ID: {$ultimo->id_riego}, Fecha: {$ultimo->fecha_programada}, Estado: {$ultimo->id_estado}\n";
    } else {
        echo "  Sin riegos registrados.\n";
    }
}
