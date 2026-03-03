<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

function descTable($tableName) {
    echo "--- $tableName ---\n";
    try {
        $results = DB::select("DESCRIBE $tableName");
        foreach ($results as $row) {
            print_r($row);
        }
    } catch (\Exception $e) {
        echo "Error describing $tableName: " . $e->getMessage() . "\n";
    }
}

descTable('tipo_riego');
descTable('riego');
