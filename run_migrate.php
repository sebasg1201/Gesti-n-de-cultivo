<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

try {
    $kernel->call('migrate', ['--force' => true]);
    file_put_contents('migrate_output.txt', $kernel->output());
} catch (\Throwable $e) {
    file_put_contents('migrate_output.txt', $e->getMessage());
}
echo "Done";
