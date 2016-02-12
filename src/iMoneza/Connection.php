<?php
/**
 * The connection to iMoneza
 *
 * @author Aaron Saray
 */

namespace iMoneza;
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
     * @var string the base of the access api
     */
    protected $baseURLAccessAPI = 'https://accessapi.imoneza.com';

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

    public function request()
    {
        $url = $this->baseURLAccessAPI;

        $this->debug('Set URL', [$url]);
        $this->request->setUrl($url);

        $this->debug('Beginning request');
        $result = $this->request->execute();
        $this->debug('Request completed.', ['INFO' => $this->request->getResponseInfo(), 'BODY' => $result]);


        return $result;
    }

    /**
     * @param $url string the base URL in case it is different (useful for testing)
     */
    public function setBaseURLAccessAPI($url)
    {
        $this->baseURLAccessAPI = $url;
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