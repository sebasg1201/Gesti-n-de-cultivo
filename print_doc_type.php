<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;

$res = DB::select("SHOW COLUMNS FROM usuario LIKE 'documento'");
foreach ($res as $r) {
    echo "TYPE: " . $r->Type . "\n";
}
