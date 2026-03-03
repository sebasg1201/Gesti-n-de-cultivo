<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\Schema;
echo "TIPO_RIEGO: " . implode(',', Schema::getColumnListing('tipo_riego')) . "\n";
echo "RIEGO: " . implode(',', Schema::getColumnListing('riego')) . "\n";
