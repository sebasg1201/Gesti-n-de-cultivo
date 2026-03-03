<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // 1. Get a real user and cosecha
    $usuario = \App\Models\Usuario::first();
    $cosecha = \App\Models\TipoCosecha::first();
    
    echo "USER: " . $usuario->documento . "\n";
    echo "COSECHA: " . $cosecha->id_tipo_cosecha . "\n";

    \App\Models\FaseProgramada::create([
        'id_cosecha' => $cosecha->id_tipo_cosecha,
        'descripcion' => 'Prueba con ids reales',
        'estado' => 'Pendiente',
        'fecha_programada' => '2026-01-01',
        'id_usuario' => $usuario->documento
    ]);
    echo "SUCCESS\n";
} catch (\Illuminate\Database\QueryException $e) {
    file_put_contents('sql_error.txt', "QUERY ERROR: " . $e->getMessage() . "\nSQL: " . $e->getSql());
    echo "ERROR SAVED\n";
} catch (\Exception $e) {
    echo "GENERIC ERROR: " . $e->getMessage() . "\n";
}
