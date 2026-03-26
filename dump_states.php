<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Models\Estado;
$estados = Estado::all(['id_estado', 'nombre_estado'])->toArray();
echo json_encode($estados, JSON_PRETTY_PRINT);
