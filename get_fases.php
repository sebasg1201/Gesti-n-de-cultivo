<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$fs = Illuminate\Support\Facades\DB::table('fases_programadas')->select('id_estado')->distinct()->get();
file_put_contents('fases_est.json', json_encode($fs, JSON_PRETTY_PRINT));
