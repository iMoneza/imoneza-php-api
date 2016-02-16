<?php
/**
 * Get the resource
 *
 * @author Aaron Saray
 */

namespace iMoneza\Options\Access;

use iMoneza\Options\OptionsAbstract;

/**
 * Class ResourceFromResourceKey
 * @package iMoneza\Options\Access
 */
class ResourceFromResourceKey extends OptionsAbstract
{
    /**
     * @var string the access key for this request (private because not part of url) @todo might make this shared?
     */
    private $accessKey = '';

    /**
     * @var string the resource key (private because part of URL)
     */
    private $resourceKey = '';

    /**
     * @var string the url of this resource
     */
    protected $ResourceURL = '';

    /**
     * @var string the user token
     */
    protected $UserToken = '';

    /**
     * @var string the IP address
     */
    protected $IP = '';

    /**
     * @var string the base of the access api
     */
    private $baseURLAccessAPI = 'https://accessapi.imoneza.com';

    /**
     * Gets the base URL
     * @return string
     */
    public function getApiBaseURL()
    {
        return $this->baseURLAccessAPI;
    }

    /**
     * Set the URL
     *
     * @param $baseUrl
     * @return $this
     */
    public function setApiBaseURL($baseUrl)
    {
        $this->baseURLAccessAPI;
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
     * @param mixed $resourceKey
     * @return $this
     */
    public function setResourceKey($resourceKey)
    {
        $this->resourceKey = $resourceKey;
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
     * @param mixed $UserToken
     * @return $this
     */
    public function setUserToken($UserToken)
    {
        $this->UserToken = $UserToken;
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
        return "/api/Resource/{$this->accessKey}/{$this->resourceKey}";
    }

    /**
     * @return string
     */
    public function getRequestType()
    {
        return self::REQUEST_TYPE_GET;
    }
}