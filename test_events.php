<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = \App\Models\Usuario::where('documento', '12345678')->first();
auth()->guard('usuario')->setUser($u);
$c = new \App\Http\Controllers\Admin\AdminController();
$events = $c->getEventosCalendario()->getOriginalContent();
file_put_contents('test_events.json', json_encode($events, JSON_PRETTY_PRINT));
echo "Done\n";
