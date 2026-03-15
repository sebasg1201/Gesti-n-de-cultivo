<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$estados = \App\Models\Estado::all();
foreach($estados as $e) {
    echo "ID: " . $e->id_estado . " => " . $e->nombre_estado . "\n";
}
