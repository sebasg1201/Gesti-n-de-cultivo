<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Cosecha;
use Carbon\Carbon;

$cosecha = Cosecha::first();
if (!$cosecha) die("No harvest found.");

$originalDate = $cosecha->fecha_estimada;
echo "Original: $originalDate\n";

$newDate = Carbon::parse($originalDate)->addDay();
echo "Add 1 day (omission): " . $newDate->format('Y-m-d') . "\n";

$newDateImpact = Carbon::parse($newDate)->addDays(-5);
echo "Add -5 days (input impact): " . $newDateImpact->format('Y-m-d') . "\n";

// Manual SQL Check
$dbDate = \Illuminate\Support\Facades\DB::table('cosecha')->where('id_cosecha', $cosecha->id_cosecha)->value('fecha_estimada');
echo "Database Date (Current): $dbDate\n";
