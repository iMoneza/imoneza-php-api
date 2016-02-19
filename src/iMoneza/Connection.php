<?php
/**
 * The connection to iMoneza
 *
 * @author Aaron Saray
 */

namespace iMoneza;
use iMoneza\Data\DataAbstract;
use iMoneza\Data\Resource;
use iMoneza\Exception;
use iMoneza\Options\Access\AccessInterface;
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
    private $accessApiKey;

    /**
     * @var string
     */
    private $accessApiSecret;

    /**
     * @var string
     */
    private $manageApiKey;

    /**
     * @var string
     */
    private $manageApiSecret;

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
     * @param $manageApiKey
     * @param $manageApiSecret
     * @param $accessApiKey
     * @param $accessApiSecret
     * @param RequestInterface $request
     * @param LoggerInterface $log
     */
    public function __construct($manageApiKey, $manageApiSecret, $accessApiKey, $accessApiSecret, RequestInterface $request, LoggerInterface $log)
    {
        $this->manageApiKey = $manageApiKey;
        $this->manageApiSecret = $manageApiSecret;
        $this->accessApiKey = $accessApiKey;
        $this->accessApiSecret = $accessApiSecret;
        $this->request = $request;
        $this->log = $log;
    }

    /**
     * @param OptionsAbstract $options
     * @param DataAbstract $dataObject
     * @return DataAbstract
     * @throws Exception\AccessDenied
     * @throws Exception\AuthenticationFailure
     * @throws Exception\DecodingError
     * @throws Exception\NotFound
     * @throws Exception\TransferError
     */
    public function request(OptionsAbstract $options, DataAbstract $dataObject)
    {
        $apiKey = ($options instanceof AccessInterface ? $this->accessApiKey : $this->manageApiKey);
        $apiSecret = ($options instanceof AccessInterface ? $this->accessApiSecret : $this->manageApiSecret);

        if (!$options->hasAccessKey()) $options->setAccessKey($apiKey);

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
        $token = base64_encode(hash_hmac('sha256', implode("\n", $tokenValues), $apiSecret, true));
        $this->debug('Token created', [$token]);
        $this->request->setAuthentication("{$apiKey}:{$token}")
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

        $jsonArray = json_decode($result, true);
        if (is_null($jsonArray)) {
            throw new Exception\DecodingError(json_last_error_msg(), json_last_error());
        }
        return $dataObject->populate($jsonArray);
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
                //sometimes it's a json string, sometimes it's not... so there's that.
                if (stripos($result, '{') === 0) {
                    $error = json_decode($result);
                    $errorMessage = $error->Message;
                }
                else {
                    $errorMessage = $result;
                }
                $this->log->error($errorMessage, ['CODE'=>404]);
                throw new Exception\NotFound($errorMessage, 404);
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