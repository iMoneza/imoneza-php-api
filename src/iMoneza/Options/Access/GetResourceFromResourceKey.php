<?php
/**
 * Get the resource
 *
 * @author Aaron Saray
 */

namespace iMoneza\Options\Access;

use iMoneza\Data\ResourceAccess;
use iMoneza\Options\ConfigurationTrait;
use iMoneza\Options\OptionsAbstract;

/**
 * Class GetResourceFromResourceKey
 * @package iMoneza\Options\Access
 */
class GetResourceFromResourceKey extends OptionsAbstract implements AccessInterface
{
    use ConfigurationTrait, AccessConfigurationTrait;

    /**
     * @var string status for ad blocker
     */
    const AD_BLOCKER_STATUS_UNKNOWN = 'Unknown';

    /**
     * @var string status for ad blocker
     */
    const AD_BLOCKER_STATUS_DETECTION_NOT_PERFORMED = 'DetectionNotPerformed';

    /**
     * @var string status for ad blocker
     */
    const AD_BLOCKER_STATUS_NOT_DETECTED = 'AdBlockerNotDetected';

    /**
     * @var string status for ad blocker
     */
    const AD_BLOCKER_STATUS_DETECTED = 'AdBlockerDetected';

    /**
     * @var string the resource key (private because part of get params)
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
     * @var string
     */
    protected $AdBlockerStatus = '';
    
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
     * @param string $AdBlockerStatus
     * @return GetResourceFromResourceKey
     */
    public function setAdBlockerStatus($AdBlockerStatus)
    {
        $this->AdBlockerStatus = $AdBlockerStatus;
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

    /**
     * @return ResourceAccess
     */
    public function getDataObject()
    {
        return new ResourceAccess();
    }
}