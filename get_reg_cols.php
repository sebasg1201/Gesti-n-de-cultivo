<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$cols = Illuminate\Support\Facades\Schema::getColumnListing('registro_trabajo');
file_put_contents('reg_cols.json', json_encode($cols, JSON_PRETTY_PRINT));
