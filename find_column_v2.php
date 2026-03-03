<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$searchColumn = 'cant_agua_apl';
$searchColumn2 = 'cantidad';
$tables = DB::select('SHOW TABLES');
$dbName = config('database.connections.mysql.database');
$key = "Tables_in_" . $dbName;

foreach ($tables as $table) {
    $tableName = $table->$key;
    if (Schema::hasColumn($tableName, $searchColumn)) {
        echo "MATCH: '$searchColumn' in $tableName\n";
    }
    if (Schema::hasColumn($tableName, $searchColumn2)) {
        echo "MATCH: '$searchColumn2' in $tableName\n";
    }
}
echo "DONE\n";
