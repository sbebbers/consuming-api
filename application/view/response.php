<?php
if (empty($result)) {
    $result = json_encode([
        'error' => 'no result found'
    ]);
}

header('Content-Type:application/json;charset=utf-8' . PHP_EOL, null, 202);
header('HTTP/1.1 202 Accepted');
header('Content-Length:' . strlen($result)) . PHP_EOL;

die(print_r($result, TRUE));
