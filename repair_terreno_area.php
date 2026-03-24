<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Terreno;

$terrenos = Terreno::whereNull('area_m2')->get();
$count = 0;

foreach ($terrenos as $terreno) {
    if ($terreno->Ancho && $terreno->Alto) {
        $terreno->area_m2 = $terreno->Ancho * $terreno->Alto;
        $terreno->save();
        $count++;
    }
}

echo "Se han actualizado $count terrenos.\n";
