<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$result = Illuminate\Support\Facades\DB::select('SHOW CREATE TABLE fases_programadas');
file_put_contents('fases_create.txt', print_r($result, true));
echo "Done";
