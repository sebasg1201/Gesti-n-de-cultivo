<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

$hoy = Carbon::today();
echo "Hoy: " . $hoy->toDateString() . "\n";

$tablas = ['fases_programadas', 'insumo_cosecha'];
foreach ($tablas as $t) {
    echo "\nBuscando en $t (anteriores a hoy, estado 1 o 17):\n";
    $pendientes = DB::table($t)
        ->whereIn('id_estado', [1, 17])
        ->whereDate('fecha_programada', '<', $hoy)
        ->get();
    foreach ($pendientes as $p) {
        $idField = array_key_first((array)$p);
        echo "ID ($idField): {$p->$idField}, Fecha: {$p->fecha_programada}, Estado: {$p->id_estado}\n";
    }
}
