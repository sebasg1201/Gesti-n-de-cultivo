<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

$cols = Schema::getColumnListing('tipo_riego');
echo "TABLE: tipo_riego\n";
foreach ($cols as $c) {
    echo "COL: $c\n";
}

$cols = Schema::getColumnListing('riego');
echo "TABLE: riego\n";
foreach ($cols as $c) {
    echo "COL: $c\n";
}
