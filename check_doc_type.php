<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;

$res = DB::select("SHOW COLUMNS FROM usuario LIKE 'documento'");
echo json_encode($res, JSON_PRETTY_PRINT);
