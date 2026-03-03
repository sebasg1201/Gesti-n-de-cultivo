<?php
$lines = file('storage/logs/laravel.log');
$lastLines = array_slice($lines, -200);
file_put_contents('test_log_output.txt', implode("", $lastLines));
echo "Done";
