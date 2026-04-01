<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\FaseProgramada;

$tasks = FaseProgramada::where('id_estado', 15)->latest('id_fase')->take(5)->get();
foreach ($tasks as $t) {
    echo "FASE_ID: {$t->id_fase} | TERRENO: ".($t->id_terreno ?? 'NULL')." | DESC: {$t->descripcion}\n";
}
