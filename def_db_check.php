<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

function p($t) {
    echo "TABLE: $t\n";
    $cols = Schema::getColumnListing($t);
    echo "COLS: " . implode(", ", $cols) . "\n\n";
}

p('tipo_riego');
p('riego');
