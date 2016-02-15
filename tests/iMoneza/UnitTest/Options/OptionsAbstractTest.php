<?php
/**
 * Test the populated method
 *
 * @author Aaron Saray
 */

namespace iMoneza\UnitTest\Options;

use iMoneza\Options\OptionsAbstract;

/**
 * Class OptionsAbstractTest
 * @package iMoneza\Tests\Options
 */
class OptionsAbstractTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPopulatedEmptyArray()
    {
        $stub = $this->getMockForAbstractClass('iMoneza\Options\OptionsAbstract');
        $this->assertEmpty($stub->getPopulated());
    }

    public function testGetPopulatedArrayWithNoElementsIsEmpty()
    {
        $options = new TestOptions();
        $this->assertEmpty($options->getPopulated());
    }

    public function testGetPopulatedArrayWithBothElementsReturnsOnlyProtected()
    {
        $options = new TestOptions();
        $options->setProtectedItem('protected-item');
        $options->setPrivateItem('private-item');
        $this->assertEquals(['protectedItem' => 'protected-item'], $options->getPopulated());
    }
}


class TestOptions extends OptionsAbstract
{
    protected $protectedItem;

    private $privateItem;

    public function setProtectedItem($item)
    {
        $this->protectedItem = $item;
    }

    public function setPrivateItem($item)
    {
        $this->privateItem = $item;
    }

    public function getEndPoint()
    {}

    public function getRequestType()
    {}
}