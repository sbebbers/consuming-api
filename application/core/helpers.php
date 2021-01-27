<?php
if (! defined('APPLICATION') || APPLICATION !== 0xc0ffee) {
    die('<pre>Access denied</pre>');
}

require_once (getApplicationPath(NULL, '/core/ConsumingAPIException.php'));
require_once (getApplicationPath(NULL, '/controller/RequestHandler.php'));
require_once (getApplicationPath(NULL, '/Library/Library.php'));

define('FILE_PERMISSIONS', 0644);
define('DIRECTORY_PERMISSIONS', 0755);

/**
 * <p>Gets the server filepath or route</p>
 *
 * @param string $filePath
 * @param string $fileName
 * @return string
 */
function getApplicationPath(string $filePath = NULL, string $fileName = NULL): string
{
    if (empty($filePath)) {
        $filePath = '/application/';
    }

    if ($filePath[0] !== '/') {
        $filePath = "/{$filePath}";
    }

    $filePath = str_replace('\\', '/', dirname(dirname(__DIR__)) . $filePath . $fileName);

    return str_replace('//', '/', $filePath);
}

/**
 * <p>Quick debug function</p>
 *
 * @param mixed $value
 * @param bool $die
 */
function debug($value, bool $die = FALSE): void
{
    echo '<pre>' . print_r($value, TRUE) . '</pre>';

    if ($die) {
        exit();
    }
}

/**
 * <p>Returns the short code months as a string
 * according to the Gregorian calendar</p>
 *
 * @return array
 */
function getMonths(): array
{
    return [
        '01' => 'jan',
        '02' => 'feb',
        '03' => 'mar',
        '04' => 'apr',
        '05' => 'may',
        '06' => 'jun',
        '07' => 'jul',
        '08' => 'aug',
        '09' => 'sep',
        '10' => 'oct',
        '11' => 'nov',
        '12' => 'dec'
    ];
}

/**
 * <p>Writes a log file based on date
 * and day; if log file already exists
 * then it will append the data to the
 * file.</p>
 *
 * <p>You may also send a JSON costant
 * such as JSON_PRETTY_PRINT as the second
 * parameter for more readable error logs
 * if required</p>
 *
 * @param mixed $error
 * @param int $jsonConstant
 * @return bool
 */
function writeToErrorLog($error, int $jsonConstant = NULL): bool
{
    if (empty($error)) {
        return FALSE;
    }
    $error = is_array($error) ? $error : [
        'errorDetails' => $error
    ];

    if (empty($error['date'])) {
        $error['date'] = date('Y-m-d');
        $error['time'] = date('H:i:s');
    }

    $fileNames = explode("-", $error['date']);

    $logPath = '/logs/' . getMonths()[$fileNames[1]];
    $fileName = getApplicationPath(NULL, "{$logPath}/{$fileNames[2]}.log");

    if (! is_dir(getApplicationPath(NULL, $logPath))) {
        mkdir(getApplicationPath(NULL, $logPath), DIRECTORY_PERMISSIONS, TRUE);
    }

    if (! file_exists($fileName)) {
        file_put_contents($fileName, '');
        chmod($fileName, FILE_PERMISSIONS);
    }

    $error = json_encode($error, $jsonConstant);

    return (bool) file_put_contents($fileName, $error . PHP_EOL, FILE_APPEND | LOCK_EX);
}
