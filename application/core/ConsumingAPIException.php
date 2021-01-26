<?php
namespace ShaunB\Applcation\Core;

use Exception;

class ConsumingAPIException extends Exception
{

    const CURL_FAILURE = 0x01;
}
