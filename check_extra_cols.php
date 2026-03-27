<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = ['producto', 'detalle_producto_cultivo'];
$result = [];
foreach($tables as $t) {
    $result[$t] = DB::select("SHOW COLUMNS FROM $t");
}

file_put_contents('db_extra_cols.json', json_encode($result, JSON_PRETTY_PRINT));
echo "Done\n";
