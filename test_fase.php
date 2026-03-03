<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    \App\Models\FaseProgramada::create([
        'id_cosecha' => 1,
        'descripcion' => 'Prueba',
        'estado' => 'Pendiente',
        'fecha_programada' => '2026-01-01',
        'id_usuario' => 110033
    ]);
    echo "SUCCESS";
} catch (\Illuminate\Database\QueryException $e) {
    echo "QUERY ERROR: " . $e->getMessage() . "\n";
    echo "SQL: " . $e->getSql() . "\n";
} catch (\Exception $e) {
    echo "GENERIC ERROR: " . $e->getMessage() . "\n";
}
