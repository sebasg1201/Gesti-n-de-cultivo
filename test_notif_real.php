<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Cosecha;
use App\Models\Usuario;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

$cosecha = Cosecha::first();
if (!$cosecha) {
    die("No harvest found in DB\n");
}

$id_empresa = $cosecha->id_empresa;
echo "Found harvest for company: " . $id_empresa . "\n";

$user = Usuario::where('id_empresa', $id_empresa)->where('id_tipo_usuario', 1)->first();
if (!$user) {
    die("No admin found for company " . $id_empresa . "\n");
}

Auth::guard('usuario')->login($user);
$service = new NotificationService();
$notifs = $service->getAdminNotifications();

echo "User: " . $user->nombre . "\n";
echo "Notifications count: " . count($notifs) . "\n";
foreach ($notifs as $n) {
    echo "- [" . $n['type'] . "] " . $n['title'] . ": " . $n['message'] . " (" . $n['date']->diffForHumans() . ")\n";
}
