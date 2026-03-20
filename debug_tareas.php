<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

$hoy = Carbon::today();
echo "Hoy: " . $hoy->toDateString() . "\n";

echo "--- FASES PROGRAMADAS pendientes/en proceso anteriores a hoy ---\n";
$fases = DB::table('fases_programadas')
    ->whereIn('id_estado', [1, 17])
    ->whereDate('fecha_programada', '<', $hoy)
    ->get();
foreach ($fases as $f) {
    echo "ID: {$f->id_fase}, Fecha: {$f->fecha_programada}, Estado: {$f->id_estado}\n";
}

echo "\n--- INSUMOS COSECHA pendientes/en proceso anteriores a hoy ---\n";
$insumos = DB::table('insumo_cosecha')
    ->whereIn('id_estado', [1, 17])
    ->whereDate('fecha_programada', '<', $hoy)
    ->get();
foreach ($insumos as $i) {
    echo "ID: {$i->id_insumo_cosecha}, Fecha: {$i->fecha_programada}, Estado: {$i->id_estado}\n";
}
