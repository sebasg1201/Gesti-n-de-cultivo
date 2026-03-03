<?php
$text = file_get_contents('test_output.txt');
echo substr($text, 0, 1000);
