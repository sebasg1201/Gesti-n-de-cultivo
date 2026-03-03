<?php
$content = file_get_contents('storage/logs/laravel.log');
preg_match_all('/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] local\.ERROR: (.*?) {/s', $content, $matches);
if (!empty($matches[1])) {
    echo 'LATEST ERROR: ' . end($matches[1]);
} else {
    echo 'NO MATCH';
}
