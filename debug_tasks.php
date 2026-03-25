<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\FaseProgramada;
use App\Models\Riego;
use App\Models\InsumoCosecha;
use App\Models\Usuario;
use Carbon\Carbon;

$id_empresa = "834324234";
echo "Empresa ID: $id_empresa\n";

$inicioSemana = Carbon::now()->subDays(7)->startOfDay();
$finSemana = Carbon::now()->endOfDay();

echo "Ventana: $inicioSemana - $finSemana\n";

$fases = FaseProgramada::whereHas('cosecha', function($q) use ($id_empresa) {
    $q->where('id_empresa', $id_empresa);
})->whereBetween('fecha_programada', [$inicioSemana, $finSemana])->get();

$riegos = Riego::whereHas('cosecha', function($q) use ($id_empresa) {
    $q->where('id_empresa', $id_empresa);
})->whereBetween('fecha_programada', [$inicioSemana, $finSemana])->get();

$insumos = InsumoCosecha::whereHas('cosecha', function($q) use ($id_empresa) {
    $q->where('id_empresa', $id_empresa);
})->whereBetween('fecha_programada', [$inicioSemana, $finSemana])->get();

echo "Fases: " . $fases->count() . "\n";
foreach($fases as $f) {
    echo "  - ID: {$f->id_fase_programada}, Fecha: {$f->fecha_programada}, Estado: {$f->id_estado}, Desc: {$f->descripcion}\n";
}

echo "Riegos: " . $riegos->count() . "\n";
foreach($riegos as $r) {
    echo "  - ID: {$r->id_riego}, Fecha: {$r->fecha_programada}, Estado: {$r->id_estado}, Obs: {$r->observaciones}\n";
}

echo "Insumos: " . $insumos->count() . "\n";
foreach($insumos as $i) {
    echo "  - ID: {$i->id_insumo_cosecha}, Fecha: {$i->fecha_programada}, Estado: {$i->id_estado}\n";
}
