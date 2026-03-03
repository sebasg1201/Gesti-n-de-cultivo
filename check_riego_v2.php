<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$table = 'riego';
echo "--- Table: $table ---\n";
$cols = Schema::getColumnListing($table);
foreach ($cols as $col) {
    echo "Column: $col\n";
}

echo "\n--- Sample Data ---\n";
$data = DB::table($table)->get();
print_r($data->toArray());
?>
