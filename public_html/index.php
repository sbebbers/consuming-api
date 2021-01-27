<?php
define('APPLICATION', 0xc0ffee);

require_once ('./../application/core/helpers.php');

writeToErrorLog([
    'TEST ' . time()
], JSON_PRETTY_PRINT);

exit();
