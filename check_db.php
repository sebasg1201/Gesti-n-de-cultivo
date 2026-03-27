<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$table = 'registro_trabajo';
echo "Columns in $table:\n";
$columns = Schema::getColumnListing($table);
foreach ($columns as $column) {
    echo "- $column\n";
}

$cultivoCols = Schema::getColumnListing('cultivo');
echo "\nColumns in cultivo:\n";
foreach ($cultivoCols as $col) {
    echo "- $col\n";
}
