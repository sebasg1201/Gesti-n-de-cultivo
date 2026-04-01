<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cosecha;
use App\Models\FaseProgramada;

echo "--- REPORTE DE COSECHAS PROGRAMADAS (ID 10) ---\n";
$cosechas = Cosecha::where('id_estado', 10)->get();
foreach ($cosechas as $c) {
    echo "ID Cosecha: {$c->id_cosecha} | Terreno: {$c->id_terreno} | Estado: {$c->id_estado} | Semilla: {$c->semilla->nombre_semilla}\n";
    
    // Buscar tareas vinculadas
    $tasks = FaseProgramada::where('id_terreno', $c->id_terreno)->get();
    foreach ($tasks as $t) {
        echo "  -> Tarea ID: {$t->id_fase} | Estado: {$t->id_estado} | Terreno Task: {$t->id_terreno} | Desc: {$t->descripcion}\n";
    }
}

echo "\n--- REPORTE DE TAREAS COMPLETADAS (ID 15) RECIENTES ---\n";
$completed = FaseProgramada::where('id_estado', 15)->latest('id_fase')->take(5)->get();
foreach ($completed as $t) {
    echo "ID Fase: {$t->id_fase} | Terreno: ".($t->id_terreno ?? 'NULL')." | Desc: {$t->descripcion}\n";
}
