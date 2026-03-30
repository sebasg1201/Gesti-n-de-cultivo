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

$worker = Usuario::where('id_tipo_usuario', 3)->first();
if (!$worker) die("No worker found\n");

$cosecha = Cosecha::first();
if ($cosecha) {
    echo "Testing Worker: {$worker->nombre} for Harvest #{$cosecha->id_cosecha}\n";
    
    // Ensure harvest is active/pending
    $cosecha->update(['id_estado' => 1, 'fecha_siembra' => now()->subDays(30)]);
    
    // Link worker via a task
    Riego::updateOrCreate(
        ['id_cosecha' => $cosecha->id_cosecha, 'documento_trabajador' => $worker->documento],
        ['id_estado' => 1, 'fecha_programada' => now()->subDays(5), 'id_catalogo_riego' => 1]
    );
}

Auth::guard('usuario')->login($worker);
$service = new NotificationService();
$notifs = $service->getNotifications();

echo "Count: " . count($notifs) . "\n";
foreach ($notifs as $n) {
    echo "- [" . $n['type'] . "] " . $n['title'] . ": " . $n['message'] . " (" . $n['date']->diffForHumans() . ")\n";
}
