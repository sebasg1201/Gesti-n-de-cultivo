<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;

$columns = DB::select("SHOW COLUMNS FROM tipo_cosecha");
foreach ($columns as $column) {
    echo "COL: {$column->Field} | TYPE: {$column->Type}\n";
}
