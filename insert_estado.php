<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

Illuminate\Support\Facades\DB::table('estado')->insertOrIgnore([
    ['id_estado' => 9, 'nombre_estado' => 'Finalizado']
]);

echo "State 9 successfully added.";
