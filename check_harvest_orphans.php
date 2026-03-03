<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;

$orphans = DB::select("
    SELECT tc.id_tipo_cosecha, tc.id_riego 
    FROM tipo_cosecha tc
    LEFT JOIN tipo_riego tr ON tc.id_riego = tr.id_tipo_riego
    WHERE tr.id_tipo_riego IS NULL AND tc.id_riego IS NOT NULL
");

echo json_encode($orphans, JSON_PRETTY_PRINT);
