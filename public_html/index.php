<?php
use ShaunB\Appplcation\Controller\RequestHandler;
use ShaunB\Appplcation\Controller\Register;

define('APPLICATION', 0xc0ffee);
define('CREDENTIALS', 'credentials-test.json');

require_once ('./../application/core/helpers.php');

$credentialPath = getApplicationPath('/auth/', CREDENTIALS);

if (! file_exists($credentialPath)) {
    http_response_code(500);
    $error = [
        'File missing: ' . CREDENTIALS
    ];

    require_once (getApplicationPath(NULL, '/view/error-response.php'));
}

$postCredentials = json_decode(file_get_contents($credentialPath))->post;

exit();
