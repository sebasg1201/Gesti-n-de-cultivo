<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$out = "";
$estados = \App\Models\Estado::all();
foreach($estados as $e) {
    if ($e->id_estado >= 1) $out .= $e->id_estado . ' - ' . $e->nombre_estado . PHP_EOL;
}
file_put_contents(__DIR__.'/estados_log.txt', $out);
echo "Done";
