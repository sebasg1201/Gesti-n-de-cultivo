<?php
$content = file_get_contents('mig.txt');
$content = mb_convert_encoding($content, 'UTF-8', 'UTF-16LE');
echo $content;
