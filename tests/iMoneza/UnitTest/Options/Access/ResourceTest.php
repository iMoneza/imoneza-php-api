<?php
/**
 * test
 *
 * @author Aaron Saray
 */

namespace iMoneza\UnitTest\Options\Access;

use iMoneza\Options\Access\Resource;

/**
 * Class ResourceTest
 * @package iMoneza\Tests\Options\Access
 */
class ResourceTest extends \PHPUnit_Framework_TestCase
{
    public function testSetAccessKey()
    {
        $options = new Resource();
        $this->assertInstanceOf('iMoneza\Options\Access\Resource', $options->setAccessKey('access-key'));
        $this->assertAttributeEquals('access-key', 'accessKey', $options);
    }

    public function testSetResourceKey()
    {
        $options = new Resource();
        $this->assertInstanceOf('iMoneza\Options\Access\Resource', $options->setResourceKey('resource-key'));
        $this->assertAttributeEquals('resource-key', 'resourceKey', $options);
    }

    public function testSetResourceURL()
    {
        $options = new Resource();
        $this->assertInstanceOf('iMoneza\Options\Access\Resource', $options->setResourceURL('resource-url'));
        $this->assertAttributeEquals('resource-url', 'resourceURL', $options);
    }

    public function testSetUserToken()
    {
        $options = new Resource();
        $this->assertInstanceOf('iMoneza\Options\Access\Resource', $options->setUserToken('user-token'));
        $this->assertAttributeEquals('user-token', 'userToken', $options);
    }

    public function testSetIpAddress()
    {
        $options = new Resource();
        $this->assertInstanceOf('iMoneza\Options\Access\Resource', $options->setIpAddress('123.123.123.123'));
        $this->assertAttributeEquals('123.123.123.123', 'ipAddress', $options);
    }

    public function testGetRequestType()
    {
        $options = new Resource();
        $this->assertEquals('get', $options->getRequestType());
    }

    public function testGetEndPoint()
    {
        $options = new Resource();
        $options->setAccessKey('access-key')->setResourceKey('resource-key');
        $this->assertEquals('/api/Resource/access-key/resource-key', $options->getEndPoint());
    }
}