<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Terreno;

$terrenos = Terreno::whereNull('area_m2')->orWhere('area_m2', 0)->get();
$count = 0;

foreach ($terrenos as $terreno) {
    if ($terreno->Ancho && $terreno->Largo) {
        $terreno->area_m2 = $terreno->Ancho * $terreno->Largo;
        $terreno->save();
        $count++;
    }
}

echo "Se han actualizado $count terrenos.\n";
