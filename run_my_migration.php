<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    \Illuminate\Support\Facades\Artisan::call('migrate', [
        '--path' => 'database/migrations/2026_03_15_120413_insert_estados_fases_cosecha.php',
        '--force' => true
    ]);
    echo \Illuminate\Support\Facades\Artisan::output();
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
