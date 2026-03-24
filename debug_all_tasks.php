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

$fases = FaseProgramada::whereHas('cosecha', function($q) use ($id_empresa) {
    $q->where('id_empresa', $id_empresa);
})->get();

$riegos = Riego::whereHas('cosecha', function($q) use ($id_empresa) {
    $q->where('id_empresa', $id_empresa);
})->get();

$insumos = InsumoCosecha::whereHas('cosecha', function($q) use ($id_empresa) {
    $q->where('id_empresa', $id_empresa);
})->get();

echo "Fases: \n";
foreach($fases as $f) {
    echo "  - ID: {$f->id_fase_programada}, Fecha: {$f->fecha_programada}, Estado: {$f->id_estado}, Cosecha: {$f->id_cosecha}\n";
}

echo "Riegos: \n";
foreach($riegos as $r) {
    echo "  - ID: {$r->id_riego}, Fecha: {$r->fecha_programada}, Estado: {$r->id_estado}\n";
}

echo "Insumos: \n";
foreach($insumos as $i) {
    echo "  - ID: {$i->id_insumo_cosecha}, Fecha: {$i->fecha_programada}, Estado: {$i->id_estado}\n";
}
