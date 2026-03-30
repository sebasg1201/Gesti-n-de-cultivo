<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Usuario;
use App\Models\Riego;
use App\Models\Cosecha;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

// Find a worker (id_tipo_usuario = 3)
$worker = Usuario::where('id_tipo_usuario', 3)->first();
if (!$worker) {
    die("No worker found\n");
}

echo "Testing for Worker: " . $worker->nombre . " (" . $worker->documento . ")\n";

// Assign worker to a crop if not already
$cosecha = Cosecha::first();
if ($cosecha) {
    echo "Linking worker to harvest #" . $cosecha->id_cosecha . "\n";
    Riego::updateOrCreate(
        ['id_cosecha' => $cosecha->id_cosecha, 'documento_trabajador' => $worker->documento],
        ['id_estado' => 1, 'fecha_programada' => now()->subDays(10), 'id_catalogo_riego' => 1]
    );
}

Auth::guard('usuario')->login($worker);
$service = new NotificationService();
$notifs = $service->getNotifications();

echo "Notifications count: " . count($notifs) . "\n";
foreach ($notifs as $n) {
    echo "- [" . $n['type'] . "] " . $n['title'] . ": " . $n['message'] . " (" . $n['date']->diffForHumans() . ")\n";
}
