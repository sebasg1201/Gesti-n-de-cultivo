<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Altering registro_trabajo table...\n";
    DB::statement("ALTER TABLE registro_trabajo MODIFY id_fase INT(11) NULL");
    DB::statement("ALTER TABLE registro_trabajo MODIFY id_riego INT(11) NULL");
    DB::statement("ALTER TABLE registro_trabajo MODIFY id_insumo_cosecha INT(11) NULL");
    echo "Success!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
