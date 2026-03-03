<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$fks = DB::select("
    SELECT TABLE_NAME, COLUMN_NAME
    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
    WHERE REFERENCED_TABLE_NAME = 'tipo_riego'
    AND TABLE_SCHEMA = 'cultivos'
");

echo json_encode($fks, JSON_PRETTY_PRINT);
