<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CatalogoRiego;
use App\Models\TipoInsumo;
use App\Models\CatalogoSuelo;

$data = [
    'riego' => CatalogoRiego::all()->toArray(),
    'insumo_tipo' => TipoInsumo::all()->toArray(),
    'suelo' => CatalogoSuelo::all()->toArray(),
];

$json = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents('ids_dump.json', $json);
echo "Done\n";

