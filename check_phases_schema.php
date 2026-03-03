<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\Schema;
echo "FASES_PROGRAMADAS: " . implode(',', Schema::getColumnListing('fases_programadas')) . "\n";
?>
