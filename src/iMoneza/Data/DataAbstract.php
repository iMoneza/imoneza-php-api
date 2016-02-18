<?php
/**
 * abstract data
 *
 * @author Aaron Saray
 */

namespace iMoneza\Data;

/**
 * Class DataAbstract
 * @package iMoneza\Data
 */
abstract class DataAbstract
{
    /**
     * @var array keys to create date time objects
     */
    protected $dateTimeKeys = [];

    /**
     * @var array keys to create classes
     */
    protected $classKeys = [];

    /**
     * Populate the class
     * @param array $values
     * @return $this
     */
    public function populate(array $values = [])
    {
        foreach ($values as $key => $value) {
            if (in_array($key, $this->dateTimeKeys)) {
                $value = new \DateTime($value, new \DateTimeZone('UTC'));
            }
            elseif (in_array($key, $this->classKeys)) {
                $className = sprintf('%s\%s', __NAMESPACE__, $key);
                $value = new $className($value);
            }
            $this->{'set' . $key}($value);
        }

        return $this;
    }
}