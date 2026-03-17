<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$cols = [
    'fases' => Illuminate\Support\Facades\Schema::getColumnListing('fases_programadas'),
    'riego' => Illuminate\Support\Facades\Schema::getColumnListing('riego'),
    'insumos' => Illuminate\Support\Facades\Schema::getColumnListing('insumos_cosechas'),
];
file_put_contents('cols.json', json_encode($cols, JSON_PRETTY_PRINT));
