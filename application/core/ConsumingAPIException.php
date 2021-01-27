<?php
namespace ShaunB\Applcation\Core;

use Exception;

class ConsumingAPIException extends Exception
{

    const CURL_FAILURE = 0x01;

    const MISSING_PARAMETER = 0x02;
}
