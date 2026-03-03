<?php
include 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;

$res = DB::select("SHOW CREATE TABLE tipo_cosecha");
echo $res[0]->{'Create Table'};
?>
