<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    Illuminate\Support\Facades\DB::statement('ALTER TABLE fases_programadas DROP FOREIGN KEY fases_programadas_ibfk_2');
    echo "Dropped old fk.\n";
} catch (\Exception $e) {
    echo "Error dropping fk: " . $e->getMessage() . "\n";
}

try {
    Illuminate\Support\Facades\DB::statement('ALTER TABLE fases_programadas ADD CONSTRAINT fases_programadas_ibfk_2 FOREIGN KEY (id_cosecha) REFERENCES tipo_cosecha (id_tipo_cosecha)');
    echo "Added new fk.\n";
} catch (\Exception $e) {
    echo "Error adding fk: " . $e->getMessage() . "\n";
}
