<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Riego;

echo "--- LISTA DE TODOS LOS RIEGOS ---\n";
$riegos = Riego::all();
foreach ($riegos as $r) {
    echo "ID: {$r->id_riego}, Fecha: {$r->fecha_programada}, Estado: {$r->id_estado}, Cosecha: {$r->id_cosecha}\n";
}
