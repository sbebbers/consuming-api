<?php
namespace ShaunB\Appplcation\Controller;

use ShaunB\Applcation\Core\ConsumingAPIException;

class RequestHandler
{

    /**
     * <p>Curl object to perform request</p>
     *
     * @var false|resource
     */
    protected $cURL;

    /**
     * <p>Api Config</p>
     *
     * @var mixed
     */
    protected $config;

    /**
     * <p>URL for the API end point</p>
     *
     * @var string $apiEndPoint
     */
    protected $apiEndPoint;

    /**
     * <p>For any HTTP headers that need setting</p>
     *
     * @var string $header
     */
    protected $header;

    /**
     * <p>Contructor; initialises the cURL resource </p>
     *
     * @throws ConsumingAPIException
     */
    public function __construct()
    {
        $this->cURL = curl_init();

        if (FALSE === $this->cURL) {
            throw new ConsumingAPIException('cURL resource failed in ' . __CLASS__, ConsumingAPIException::CURL_FAILURE);
        }
    }

    /**
     * <p>Sets basic options for cURL request;
     * additional options may be added or
     * over-ridden with an array of key => value
     * pairs</p>
     *
     * @param array $options
     * @throws ConsumingAPIException
     * @return void
     * @uses <p>Add or over-ride options in the following example:</p>
     *       <pre>$curlOptions = [</pre>
     *       <pre> CURLOPT_RETURNTRANSFER => 0,</pre>
     *       <pre> CURLOPT_FAILONERROR => 1</pre>
     *       <pre>];</pre>
     *       <pre>RegentOceania\APIHelper::setCURLOptions($curlOptions);</pre>
     */
    private function setCURLOptions($options = []): void
    {
        if (! ($urlEndPoint = $this->apiEndPoint)) {
            throw new ConsumingAPIException('No defined end point found in ' . __METHOD__ . '()');
        }

        curl_setopt($this->cURL, CURLOPT_URL, $urlEndPoint);
        curl_setopt($this->cURL, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($this->cURL, CURLOPT_FAILONERROR, TRUE);

        if (! empty($options)) {
            foreach ($options as $curlOpt => $curlValue) {
                curl_setopt($this->cURL, $curlOpt, $curlValue);
            }
        }
    }

    /**
     * <p>Excepts an executed cURL request
     * and processes the response</p>
     *
     * @throws ConsumingAPIException
     * @return string
     */
    private function executeCURLRequest(): ?string
    {
        $response = curl_exec($this->cURL);
        $cURLError = curl_error($this->cURL) ? [
            'cURL-Error' => curl_error($this->cURL)
        ] : [];
        $errorResponse = [];

        if (empty($errorResponse) && empty($cURLError)) {
            return $response;
        }

        foreach ($errorResponse as $key => $errorDetails) {
            $cURLError[$key] = $errorDetails;
        }
        $errorString = '';

        foreach ($cURLError as $key => $data) {
            $errorString .= "{$key}: " . is_string($data) ? $data : print_r($data, TRUE);
            $errorString .= PHP_EOL;
        }
        $cURLErrorNumber = (curl_errno($this->cURL) > 0) ? curl_errno($this->cURL) : 418;

        throw new ConsumingAPIException($errorString, $cURLErrorNumber);
    }

    /**
     * <p>Make the api call with XML payload</p>
     *
     * @param string $postData
     * @throws ConsumingAPIException
     * @return string
     */
    public function apiCall(array $postData = NULL): ?string
    {
        try {
            $this->setCURLOptions([
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_HTTPHEADER => $this->header
            ]);

            return $this->executeCURLRequest();
        } catch (ConsumingAPIException $e) {
            throw $e;
        }
    }

    /**
     * <p>Sets the end point resource locator for the cURL
     * request</p>
     *
     * @param string $endPoint
     * @return RequestHandler
     */
    public function setAPIEndPoint(string $endPoint): RequestHandler
    {
        $this->apiEndPoint = $endPoint;

        return $this;
    }

    /**
     * <p>Sets HTML header</p>
     *
     * @param array $htmlHeader
     * @return RequestHandler
     */
    public function setHeader(array $htmlHeader): RequestHandler
    {
        $this->header = $htmlHeader;

        return $this;
    }

    /**
     * <p>Destructor</p>
     *
     * @return void
     */
    public function __destruct()
    {
        $this->cURL = curl_close($this->cURL);
    }
}
