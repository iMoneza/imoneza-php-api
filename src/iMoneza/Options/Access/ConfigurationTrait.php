<?php
/**
 * Shared "private" configuration options
 *
 * @author Aaron Saray
 */

namespace iMoneza\Options\Access;

/**
 * Class ConfigurationTrait
 * @package iMoneza\Options\Access
 */
trait ConfigurationTrait
{
    /**
     * @var string the access key for this request
     */
    private $accessKey = '';

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
        $this->apiBaseUrl = $baseUrl;
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

}