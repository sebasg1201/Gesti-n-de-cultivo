<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = ['proveedor', 'entrada_insumo', 'insumo', 'tipo_semilla'];
$res = [];
foreach ($tables as $t) {
    try {
        $columns = \Illuminate\Support\Facades\DB::select("DESCRIBE $t");
        $res[$t] = $columns;
    } catch (\Exception $e) {
        $res[$t] = $e->getMessage();
    }
}
file_put_contents(__DIR__ . '/tmp_proveedor.json', json_encode($res, JSON_PRETTY_PRINT));
