<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

$table1 = 'tipo_riego';
$table2 = 'riego';

echo "START_DB_INFO\n";
echo "TIPO_RIEGO:" . implode(",", Schema::getColumnListing($table1)) . "\n";
echo "RIEGO:" . implode(",", Schema::getColumnListing($table2)) . "\n";
echo "END_DB_INFO\n";
