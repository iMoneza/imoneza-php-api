<?php
/**
 * Save (PUT) a resource
 *
 * @author Aaron Saray
 */

namespace iMoneza\Options\Management;

use iMoneza\Options\ConfigurationTrait;
use iMoneza\Options\OptionsAbstract;

/**
 * Class SaveResource
 * @package iMoneza\Options\Management
 */
class SaveResource extends OptionsAbstract implements ManagementInterface
{
    use ConfigurationTrait, ManagementConfigurationTrait;

    /**
     * @var string the external key to use for this reference
     */
    protected $externalKey;

    /**
     * @var string the internal name
     */
    protected $name;

    /**
     * @var string the title of the item
     */
    protected $title;

    /**
     * @return string
     */
    public function getExternalKey()
    {
        return $this->externalKey;
    }

    /**
     * @param string $externalKey
     * @return $this
     */
    public function setExternalKey($externalKey)
    {
        $this->externalKey = $externalKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return SaveResource
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return SaveResource
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndPoint()
    {
        return "/api/Property/{$this->accessKey}/Resource/{$this->externalKey}";
    }

    /**
     * @return string
     */
    public function getRequestType()
    {
        return self::REQUEST_TYPE_PUT;
    }
}