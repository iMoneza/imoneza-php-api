<?php
/**
 * Callback Result
 *
 * @author Aaron Saray
 */

namespace iMoneza\Data;

/**
 * Class None
 * @package iMoneza\Data
 */
class CallbackResult extends DataAbstract
{
    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function __call($key, $value)
    {
        if (stripos($key, 'set') === 0) {
            $newKey = substr($key, 3);
            $this->$newKey = $value;
        }
        return $this;
    }
}
