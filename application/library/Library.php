<?php
namespace ShaunB\Application\Library;

use ShaunB\Applcation\Core\ConsumingAPIException;

class Library
{

    /**
     * <p>Gives a visual display of the unit tests
     * if the $visualOutput parameter is set</p>
     *
     * @param mixed $result
     * @param mixed $expectedResult
     * @see Library::unitTest()
     */
    private function showTestResults($result, $expectedResult): void
    {
        echo '<p>Expected: ' . $expectedResult . ', Actual: ' . $result . '</p>';
        echo '<p style="';
        echo $result === $expectedResult ? 'color:green">Test matched expected result' : 'color: red">Test failed';
        echo '</p>';
    }

    /**
     * <p>On screen method testing (non-static methods)</p>
     *
     * @param object $object
     * @param string $method
     * @param mixed $params
     * @param mixed $expectedResult
     * @param bool $visualOutput
     * @return bool
     */
    public function unitTest(object &$object, string $method, $params, $expectedResult, bool $visualOutput): bool
    {
        $error = $errorCode = NULL;

        if (is_array($params)) {
            try {
                $result = $object->{$method}($params[0], $params[1] ?? NULL, $params[2] ?? NULL, $params[3] ?? NULL, $params[4] ?? NULL, $params[5] ?? NULL, $params[6] ?? NULL);
            } catch (ConsumingAPIException $e) {
                $error = $e->getMessage();
                $errorCode = $e->getCode();
            }
        } else {
            try {
                $result = $object->{$method}($params);
            } catch (ConsumingAPIException $e) {
                $error = $e->getMessage();
                $errorCode = $e->getCode();
            }
        }

        if (! empty($error)) {
            if ($visualOutput) {
                echo '<p style="color:red">Exception caught: ' . $error . '; Error code: ' . $errorCode . '</p>';
            } else {
                writeToErrorLog($error);
            }
            return FALSE;
        }

        if ($visualOutput) {
            $this->showTestResults();
        }

        return $result === $expectedResult;
    }
}
