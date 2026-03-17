<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$estados = Illuminate\Support\Facades\DB::table('estado')->get();
file_put_contents('estados.json', json_encode($estados, JSON_PRETTY_PRINT));
