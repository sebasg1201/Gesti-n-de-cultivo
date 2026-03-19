<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$existe = \App\Models\Estado::find(18);
if(!$existe) {
    \Illuminate\Support\Facades\DB::table('estado')->insert([
        'id_estado' => 18,
        'nombre_estado' => 'Perdida Oculta'
    ]);
    echo "Estado 18 creado";
} else {
    echo "Estado 18 ya existe";
}
