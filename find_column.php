<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$searchColumn = 'cant_agua_apl';
$tables = DB::select('SHOW TABLES');
$dbName = config('database.connections.mysql.database');
$key = "Tables_in_" . $dbName;

foreach ($tables as $table) {
    $tableName = $table->$key;
    if (Schema::hasColumn($tableName, $searchColumn)) {
        echo "Found '$searchColumn' in table: $tableName\n";
    }
}

$searchColumn2 = 'cantidad';
foreach ($tables as $table) {
    $tableName = $table->$key;
    if (Schema::hasColumn($tableName, $searchColumn2)) {
        echo "Found '$searchColumn2' in table: $tableName\n";
    }
}
