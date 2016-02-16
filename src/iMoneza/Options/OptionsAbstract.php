<?php
/**
 * Abstract class for options
 *
 * @author Aaron Saray
 */

namespace iMoneza\Options;
use iMoneza\Exception;

/**
 * Class OptionsAbstract
 * @package iMoneza\Options
 */
abstract class OptionsAbstract
{
    /**
     * @var string this is a post method
     */
    const REQUEST_TYPE_POST = 'post';

    /**
     * @var string this is a get method
     */
    const REQUEST_TYPE_GET = 'get';

    /**
     * @return array the populated array of elements from this set of options (note, private vars are not included - yay!)
     */
    public function getPopulated()
    {
        $properties = array_reduce(array_keys(get_class_vars(get_class($this))), function($holder, $currentKey) {
            if (!is_null($this->$currentKey)) $holder[$currentKey] = $this->$currentKey;
            return $holder;
        }, []);
        return $properties;
    }

    /**
     * Gets the URL of the base request
     *
     * @return string get the base URL
     */
    abstract public function getApiBaseURL();

    /**
     * Sets the base URL of the request
     * @param $baseUrl
     * @return mixed
     */
    abstract public function setApiBaseURL($baseUrl);

    /**
     * @return mixed the custom URL for this request
     */
    abstract public function getEndPoint();

    /**
     * @return string
     */
    abstract public function getRequestType();
}