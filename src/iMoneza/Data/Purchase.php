<?php
/**
 * Purchase
 *
 * @author Aaron Saray
 */

namespace iMoneza\Data;

/**
 * Class Purchase
 * @package iMoneza\Data
 */
class Purchase
{
    /**
     * @var boolean
     */
    protected $isPurchased;

    /**
     * Purchase constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        foreach ($values as $key => $value) {
            $this->{'set' . $key}($value);
        }
    }

    /**
     * @return boolean
     */
    public function isPurchased()
    {
        return $this->isPurchased;
    }

    /**
     * @param boolean $isPurchased
     * @return Purchase
     */
    public function setIsPurchased($isPurchased)
    {
        $this->isPurchased = $isPurchased;
        return $this;
    }
}