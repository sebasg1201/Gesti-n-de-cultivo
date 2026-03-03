<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;

$fks = DB::select("
    SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
    WHERE TABLE_NAME = 'tipo_cosecha'
    AND TABLE_SCHEMA = 'cultivos'
");

foreach ($fks as $fk) {
    if ($fk->REFERENCED_TABLE_NAME) {
        echo "COL: {$fk->COLUMN_NAME} | REF_TABLE: {$fk->REFERENCED_TABLE_NAME} | REF_COL: {$fk->REFERENCED_COLUMN_NAME}\n";
    }
}
?>
