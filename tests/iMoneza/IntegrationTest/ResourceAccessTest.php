<?php
/**
 * Tests getting the resource
 *
 * @author Aaron Saray
 */

namespace iMoneza\IntegrationTest;


use iMoneza\Data\Resource;
use iMoneza\Helper;

class ResourceAccessTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \iMoneza\Connection
     */
    protected $connection;

    public static function setUpBeforeClass()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__);
        $dotenv->load();
    }

    public function setUp()
    {
        $apiKey = getenv('ACCESS_API_KEY');
        $secretKey = getenv('ACCESS_API_SECRET');

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\StreamHandler('php://stdout'));

        $this->connection = new \iMoneza\Connection($apiKey, $secretKey, new \iMoneza\Request\Curl(), $logger);
    }

    public function testGetResourceFromResourceKey()
    {
        $options = new \iMoneza\Options\Access\ResourceFromResourceKey();
        $options->setApiBaseURL(getenv('ACCESS_API_URL')); // only for testing
        $options->setResourceKey('81')->setIP(Helper::getCurrentIP())
            ->setResourceURL('http://imonezajournal.com/2015/02/02/candidate-visits-local-business/');

        $result = $this->connection->request($options);

        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\iMoneza\Data\Resource', $result);

        return $result;
    }

    /**
     * @depends testGetResourceFromResourceKey
     */
    public function testGetResourceFromTemporaryKey(Resource $previousRequestResource)
    {
        $this->assertInstanceOf('\iMoneza\Data\Resource', $previousRequestResource);

    }
}