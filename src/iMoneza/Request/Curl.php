<?php
/**
 * Curl Request Object
 *
 * @author Aaron Saray
 */

namespace iMoneza\Request;

/**
 * Class CurlRequest
 * @package iMoneza
 */
class Curl implements RequestInterface
{
    /**
     * @var Resource
     */
    protected $handle;

    /**
     * Curl constructor.
     * Set default values
     */
    public function __construct()
    {
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
    }

    /**
     * Sets the request for this URL
     *
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->setOption(CURLOPT_URL, $url);
        return $this;
    }

    /**
     * Execute the request
     * @return bool|string
     */
    public function execute()
    {
        $this->initHandle();
        return curl_exec($this->handle);
    }

    /**
     * Get all the response info for this request
     *
     * @return mixed
     */
    public function getResponseInfo()
    {
        $this->initHandle();
        return curl_getinfo($this->handle);
    }

    /**
     * Set curl option
     *
     * @param $name
     * @param $value
     * @return $this
     */
    protected function setOption($name, $value)
    {
        $this->initHandle();
        curl_setopt($this->handle, $name, $value);
        return $this;
    }


//
//    /**
//     * Get curl info
//     * @param $name
//     * @return mixed
//     */
//    public function getInfo($name = null)
//    {
//        $this->initHandle();
//        return curl_getinfo($this->handle, $name);
//    }
//
//    /**
//     * Close handle
//     * @return $this
//     */
//    public function close()
//    {
//        if (!is_null($this->handle)) curl_close($this->handle);
//        return $this;
//    }
//
//    /**
//     * @return string
//     */
//    public function getError()
//    {
//        $this->initHandle();
//        return curl_error($this->handle);
//    }
//
//    /**
//     * @return int
//     */
//    public function getErrorNumber()
//    {
//        $this->initHandle();
//        return curl_errno($this->handle);
//    }

    /**
     * Lazy loading curl handle
     */
    protected function initHandle()
    {
        if (is_null($this->handle)) $this->handle = curl_init();
    }
}