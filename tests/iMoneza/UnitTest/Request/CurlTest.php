<?php
/**
 * Unit test
 *
 * @author Aaron Saray
 */

namespace iMoneza\UnitTest\Request;
use iMoneza\Request\Curl;

/**
 * Class CurlTest
 * @package iMoneza\UnitTest\Request
 */
class CurlTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorOptions()
    {
        $stub = $this->getMockBuilder('iMoneza\Request\Curl')
            ->disableOriginalConstructor()
            ->setMethods(['setOption'])
            ->getMock();

        $stub->method('setOption')
            ->will($this->returnCallback(function($option, $value) {
                \PHPUnit_Framework_Assert::assertEquals(CURLOPT_RETURNTRANSFER, $option);
                \PHPUnit_Framework_Assert::assertTrue($value);
            }));

        $stub->__construct();
    }

    public function testSetUrl()
    {
        $stub = $this->getMockBuilder('iMoneza\Request\Curl')
            ->setMethods(['setOption'])
            ->getMock();

        $stub->method('setOption')
            ->will($this->returnCallback(function($option, $value) {
                \PHPUnit_Framework_Assert::assertEquals(CURLOPT_URL, $option);
                \PHPUnit_Framework_Assert::assertEquals('http://google.com', $value);
            }));

        $stub->setUrl('http://google.com');
    }


}