<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$columns = \Illuminate\Support\Facades\Schema::getColumnListing('cosecha');
file_put_contents('columns_cosecha.json', json_encode($columns));
