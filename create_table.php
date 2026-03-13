<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    if (Schema::hasTable('soporte')) {
        echo "Table soporte already exists. Dropping it...\n";
        Schema::drop('soporte');
    }

    DB::statement("
        CREATE TABLE soporte (
            id_soporte BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            documento_trabajador BIGINT NOT NULL,
            id_empresa VARCHAR(255) NOT NULL,
            asunto VARCHAR(255) NOT NULL,
            mensaje TEXT NOT NULL,
            respuesta TEXT,
            estado VARCHAR(255) DEFAULT 'Pendiente',
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            INDEX(documento_trabajador),
            INDEX(id_empresa)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    echo "Table soporte created successfully!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
