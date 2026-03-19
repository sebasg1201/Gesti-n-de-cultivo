<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use App\Models\Riego;

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Print all riegos for all harvests
$riegos = Riego::orderBy('id_riego', 'desc')->take(10)->get();
echo "--- ULTIMOS 10 RIEGOS ---\n";
foreach ($riegos as $r) {
    echo "ID: {$r->id_riego} | Programada: {$r->fecha_programada} | Estado: {$r->id_estado}\n";
}
