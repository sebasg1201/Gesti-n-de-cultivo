<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$table = 'registro_trabajo';
$columns = DB::select("SHOW COLUMNS FROM $table");

file_put_contents('db_cols.json', json_encode($columns, JSON_PRETTY_PRINT));
echo "Done\n";
