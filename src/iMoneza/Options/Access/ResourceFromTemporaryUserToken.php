<?php
/**
 * Get the resource
 *
 * @author Aaron Saray
 */

namespace iMoneza\Options\Access;

use iMoneza\Options\OptionsAbstract;

/**
 * Class ResourceFromTemporaryUserToken
 * @package iMoneza\Options\Access
 */
class ResourceFromTemporaryUserToken extends OptionsAbstract
{
    /**
     * @var string the access key for this request (private because not part of get params)
     */
    private $accessKey = '';

    /**
     * @var string the resource key
     */
    protected $ResourceKey = '';

    /**
     * @var string the url of this resource
     */
    protected $ResourceURL = '';

    /**
     * @var string the user token
     */
    protected $temporaryUserToken = '';

    /**
     * @var string the IP address
     */
    protected $IP = '';

    /**
     * @var string the base of the access api
     */
    private $apiBaseUrl = 'https://accessapi.imoneza.com';

    /**
     * Gets the base URL
     * @return string
     */
    public function getApiBaseURL()
    {
        return $this->apiBaseUrl;
    }

    /**
     * Set the URL
     *
     * @param $baseUrl
     * @return $this
     */
    public function setApiBaseURL($baseUrl)
    {
        $this->apiBaseUrl;
        return $this;
    }

    /**
     * @param string $accessKey
     * @return $this
     */
    public function setAccessKey($accessKey)
    {
        $this->accessKey = $accessKey;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasAccessKey()
    {
        return !empty($this->accessKey);
    }

    /**
     * @param mixed $resourceKey
     * @return $this
     */
    public function setResourceKey($resourceKey)
    {
        $this->ResourceKey = $resourceKey;
        return $this;
    }

    /**
     * @param mixed $ResourceURL
     * @return $this
     */
    public function setResourceURL($ResourceURL)
    {
        $this->ResourceURL = $ResourceURL;
        return $this;
    }

    /**
     * @param string $temporaryUserToken
     * @return $this
     */
    public function setTemporaryUserToken($temporaryUserToken)
    {
        $this->temporaryUserToken = $temporaryUserToken;
        return $this;
    }

    /**
     * @param mixed $IP
     * @return $this
     */
    public function setIP($IP)
    {
        $this->IP = $IP;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndPoint()
    {
        return "/api/TemporaryUserToken/{$this->accessKey}/{$this->temporaryUserToken}";
    }

    /**
     * @return string
     */
    public function getRequestType()
    {
        return self::REQUEST_TYPE_GET;
    }
}