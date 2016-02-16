<?php
/**
 * The connection to iMoneza
 *
 * @author Aaron Saray
 */

namespace iMoneza;
use iMoneza\Data\Resource;
use iMoneza\Exception;
use iMoneza\Options\OptionsAbstract;
use iMoneza\Request\RequestInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Class Connection
 * @package iMoneza
 */
class Connection
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $secretKey;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Logger
     */
    private $log;

    /**
     * Connection constructor.
     * @param $apiKey string
     * @param $secretKey string
     * @param RequestInterface $request
     * @param LoggerInterface $log
     */
    public function __construct($apiKey, $secretKey, RequestInterface $request, LoggerInterface $log)
    {
        $this->apiKey = $apiKey;
        $this->secretKey = $secretKey;
        $this->request = $request;
        $this->log = $log;
    }

    /**
     * @param OptionsAbstract $options
     * @return mixed
     * @throws Exception\AccessDenied
     * @throws Exception\TransferError
     */
    public function request(OptionsAbstract $options)
    {
        if (!$options->hasAccessKey()) $options->setAccessKey($this->apiKey);

        $requestType = $options->getRequestType();
        $endPoint = $options->getEndPoint();

        $url = $options->getApiBaseURL() . $endPoint;
        $this->debug('URL', [$url]);

        $populatedValues = $options->getPopulated();
        ksort($populatedValues);

        $httpQuery = http_build_query($populatedValues);
        if ($requestType == OptionsAbstract::REQUEST_TYPE_GET && $httpQuery) {
            $url .= "?{$httpQuery}";
        }
        $this->debug('Query', [$httpQuery]);

        $this->debug('Set Full URL', [$url]);
        $this->request->setUrl($url);

        $timestamp = gmdate('D, d M Y H:i:s T');
        $tokenValues = [
            strtoupper($requestType),
            $timestamp,
            strtolower($endPoint),
            implode('&', array_map(function($key, $value) {
                return sprintf('%s=%s', strtolower($key), strtolower($value));
            }, array_keys($populatedValues), $populatedValues))  // note: this is different because it can't be escaped - unlike the http_build_query which does - and need to be lower cased
        ];

        $this->debug('Token values', $tokenValues);
        $token = base64_encode(hash_hmac('sha256', implode("\n", $tokenValues), $this->secretKey, true));
        $this->debug('Token created', [$token]);
        $this->request->setAuthentication("{$this->apiKey}:{$token}")
            ->setTimestamp($timestamp);

        $this->log->info("About to send to {$url} via {$requestType} with options of " . get_class($options));

        $this->debug('Beginning request');
        $result = $this->request->execute();
        $this->debug('Request completed.', ['INFO' => $this->request->getResponseInfo(), 'BODY' => $result]);

        $this->handleRequestError($result);

        // really shouldn't happen unless something changes or I missed something
        if (($httpCode = $this->request->getResponseHTTPCode()) !== 200) {
            $message = "HTTP Error Code of {$httpCode} was generated and not caught: " . $result;
            $this->log->error($message);
            throw new Exception\TransferError($message);
        }

        $this->debug('All error checking passed.');
        $this->log->info("The request was successful.");

        $jsonArray = json_decode($result, true); // @todo catch errors
        return new Resource($jsonArray);
    }

    /**
     * @param $url string the base URL in case it is different (useful for testing)
     */
    public function setBaseURLAccessAPI($url)
    {
        $this->baseURLAccessAPI = $url;
    }

    /**
     * Handles a potential request error by throwing a useful exception
     * @param $result string|false
     * @throws Exception\AccessDenied
     * @throws Exception\AuthenticationFailure
     * @throws Exception\NotFound
     * @throws Exception\TransferError
     */
    protected function handleRequestError($result)
    {
        /**
         * Curl error
         */
        if ($result === false) {
            throw new Exception\TransferError($this->request->getErrorString(), $this->request->getErrorCode());
        }

        switch ($this->request->getResponseHTTPCode()) {
            case 401:
                $this->log->error($result, ['CODE'=>401]);
                throw new Exception\AuthenticationFailure($result, 401);
                break;
            case 403:
                $this->log->error($result, ['CODE'=>403]);
                throw new Exception\AccessDenied($result, 403);
                break;
            case 404:
                $error = json_decode($result);
                $this->log->error($error->Message, ['CODE'=>404]);
                throw new Exception\NotFound($error->Message, 404);
                break;
        }
    }

    /**
     * @param $string
     * @param array $context
     * @return bool|null
     */
    protected function debug($string, $context = [])
    {
        return $this->log->debug($string, $context);
    }
}