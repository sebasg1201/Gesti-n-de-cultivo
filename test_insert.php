<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    \Illuminate\Support\Facades\DB::table('estado')->insert([
        'nombre_estado' => 'TestState555'
    ]);
    echo "Insert successful!\n";
    \Illuminate\Support\Facades\DB::table('estado')->where('nombre_estado', 'TestState555')->delete();
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
