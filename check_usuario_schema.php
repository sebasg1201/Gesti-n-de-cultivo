<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;

$columns = DB::select("SHOW COLUMNS FROM usuario");
echo "Column | Type | Null | Key | Default | Extra\n";
foreach ($columns as $column) {
    echo "{$column->Field} | {$column->Type} | {$column->Null} | {$column->Key} | {$column->Default} | {$column->Extra}\n";
}
