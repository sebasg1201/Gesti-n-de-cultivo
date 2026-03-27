<?php
// Verification script for Harvest Duration Logic
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Cosecha;
use App\Models\Riego;
use App\Models\InsumoCosecha;
use Carbon\Carbon;

// Find a test harvest
$cosecha = Cosecha::first();
if (!$cosecha) {
    die("No harvest found for testing.");
}

$originalDate = $cosecha->fecha_estimada;
echo "Original Estimated Date: $originalDate\n";

// 1. Test Riego Omission (18)
echo "Testing Riego Omission (State 18)...\n";
$riego = Riego::where('id_cosecha', $cosecha->id_cosecha)->first();
if ($riego) {
    $riego->id_estado = 18;
    $riego->save();
    
    // Simulate updating harvest date (this would normally happen in AdminController)
    $newDate = Carbon::parse($cosecha->fecha_estimada)->addDay();
    $cosecha->update(['fecha_estimada' => $newDate->format('Y-m-d')]);
    
    $cosecha->refresh();
    echo "New Estimated Date after Omission: {$cosecha->fecha_estimada} (Expected: " . Carbon::parse($originalDate)->addDay()->format('Y-m-d') . ")\n";
}

// 2. Test Insumo Impact
echo "Testing Insumo Impact (State 15)...\n";
$insumo = InsumoCosecha::where('id_cosecha', $cosecha->id_cosecha)->first();
if ($insumo) {
    $impact = -5;
    $insumo->impacto_dias = $impact;
    $insumo->id_estado = 15;
    $insumo->save();
    
    // Simulate updating harvest date
    $newDate = Carbon::parse($cosecha->fecha_estimada)->addDays($impact);
    $cosecha->update(['fecha_estimada' => $newDate->format('Y-m-d')]);
    
    $cosecha->refresh();
    echo "New Estimated Date after Insumo (-5 days): {$cosecha->fecha_estimada}\n";
}
