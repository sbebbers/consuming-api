<?php
if (empty($error)) {
    $error = [];
}
if (empty($result)) {
    $result = NULL;
}
$message = [
    '400' => 'Bad request',
    '401' => 'Unauthorized',
    '403' => 'Forbidden',
    '404' => 'Not found',
    '418' => 'I\'m a teapot',
    '500' => 'Internal Server Error',
    '503' => 'Service Unavailable'
];

$error['message'][] = 'There was a problem with the API or no content returned';
$error['serverStatus'] = http_response_code();

if ($error['serverStatus'] > 199 && $error['serverStatus'] < 204) {
    $error['serverStatus'] = 418;
    $error['code'] = 0xc0ffee;
}

if (is_array($result) && ! empty($result)) {
    $error = array_merge($error, $result);
}
writeToLogFile($error);

$serverStatus = $error['serverStatus'];
$error = json_encode($error, JSON_PRETTY_PRINT);

header('Content-Type:application/json;charset=utf-8' . PHP_EOL, NULL, $serverStatus);
header('HTTP/1.1 ' . $message[$serverStatus] . PHP_EOL);
header('Content-Length:' . strlen($error));

die(print_r($error, TRUE));
