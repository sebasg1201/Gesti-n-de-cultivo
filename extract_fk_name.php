<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;

$res = DB::select("SHOW CREATE TABLE fases_programadas");
$createTable = $res[0]->{'Create Table'};
if (preg_match("/CONSTRAINT `([^`]+)` FOREIGN KEY \(`id_usuario`\) REFERENCES `usuario` \(`documento`\)/", $createTable, $matches)) {
    echo "CONSTRAINT_NAME: " . $matches[1] . "\n";
} else {
    echo "CONSTRAINT NOT FOUND\n";
    echo $createTable;
}
?>
