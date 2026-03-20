<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "--- BUSCANDO TAREAS DEL 18 DE MARZO ---\n";
$tablas = ['riego', 'fases_programadas', 'insumo_cosecha'];
foreach ($tablas as $t) {
    echo "\nTABLA: $t\n";
    $tareas = DB::table($t)
        ->whereDate('fecha_programada', '2026-03-18')
        ->get();
    foreach ($tareas as $tarea) {
        $idField = array_key_first((array)$tarea);
        echo "ID ($idField): {$tarea->$idField}, Fecha: {$tarea->fecha_programada}, Estado: {$tarea->id_estado}\n";
    }
}
