<?php
/**
 * Subscription object
 *
 * @author Aaron Saray
 */

namespace iMoneza\Data;

/**
 * Class Subscription
 * @package iMoneza\Data
 */
class Subscription
{
    /**
     * @var boolean
     */
    protected $isExpired;

    /**
     * @var \DateTime
     */
    protected $expirationDate;

    /**
     * @var boolean
     */
    protected $isCurrent;

    /**
     * @var string
     */
    protected $subscriptionGroupID;

    /**
     * Subscription constructor.
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        foreach ($values as $key => $value) {
            switch ($key) {
                case 'ExpirationDate':
                    $value = new \DateTime($value, new \DateTimeZone('UTC'));
                    break;
            }

            $this->{'set' . $key}($value);
        }
    }

    /**
     * @return boolean
     */
    public function isExpired()
    {
        return $this->isExpired;
    }

    /**
     * @param boolean $isExpired
     * @return Subscription
     */
    public function setIsExpired($isExpired)
    {
        $this->isExpired = $isExpired;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param \DateTime $expirationDate
     * @return Subscription
     */
    public function setExpirationDate(\DateTime $expirationDate)
    {
        $this->expirationDate = $expirationDate;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isCurrent()
    {
        return $this->isCurrent;
    }

    /**
     * @param boolean $isCurrent
     * @return Subscription
     */
    public function setIsCurrent($isCurrent)
    {
        $this->isCurrent = $isCurrent;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubscriptionGroupID()
    {
        return $this->subscriptionGroupID;
    }

    /**
     * @param string $subscriptionGroupID
     * @return Subscription
     */
    public function setSubscriptionGroupID($subscriptionGroupID)
    {
        $this->subscriptionGroupID = $subscriptionGroupID;
        return $this;
    }


}
