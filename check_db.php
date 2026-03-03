<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

function checkTable($tableName) {
    if (Schema::hasTable($tableName)) {
        echo "Table: $tableName\n";
        $columns = Schema::getColumnListing($tableName);
        foreach ($columns as $column) {
            echo " - $column\n";
        }
    } else {
        echo "Table: $tableName does not exist.\n";
    }
}

checkTable('tipo_riego');
checkTable('riego');
