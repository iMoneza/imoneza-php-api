<?php
/**
 * test
 *
 * @author Aaron Saray
 */

namespace iMoneza\UnitTest\Options\Management;
use iMoneza\Options\Management\SaveResource;


/**
 * Class SaveResourceTest
 * @package iMoneza\Tests\Options\Access
 */
class SaveResourceTest extends \PHPUnit_Framework_TestCase
{
    public function testSetResourceKey()
    {
        $options = new SaveResource();
        $this->assertInstanceOf('iMoneza\Options\Management\SaveResource', $options->setPricingGroupId('12345'));
        $this->assertAttributeEquals(['PricingGroupID'=>12345], 'PricingGroup', $options);
    }

    public function testSetExternalKey()
    {
        $options = new SaveResource();
        $this->assertInstanceOf('iMoneza\Options\Management\SaveResource', $options->setExternalKey('external-key'));
        $this->assertAttributeEquals('external-key', 'ExternalKey', $options);
    }

    public function testSetName()
    {
        $options = new SaveResource();
        $this->assertInstanceOf('iMoneza\Options\Management\SaveResource', $options->setName('the-name'));
        $this->assertAttributeEquals('the-name', 'Name', $options);
    }

    public function testSetTitle()
    {
        $options = new SaveResource();
        $this->assertInstanceOf('iMoneza\Options\Management\SaveResource', $options->setTitle('title-here'));
        $this->assertAttributeEquals('title-here', 'Title', $options);
    }

    public function testGetRequestType()
    {
        $options = new SaveResource();
        $this->assertEquals('put', $options->getRequestType());
    }

    public function testGetEndPoint()
    {
        $options = new SaveResource();
        $options->setAccessKey('access-key')->setExternalKey('external-key');
        $this->assertEquals('/api/Property/access-key/Resource/external-key', $options->getEndPoint());
    }

    public function testGetDataObject()
    {
        $options = new SaveResource();
        $this->assertInstanceOf('iMoneza\Data\None', $options->getDataObject());
    }
}