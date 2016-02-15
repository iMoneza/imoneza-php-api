<?php
/**
 * Tests getting the resource
 *
 * @author Aaron Saray
 */

namespace iMoneza\IntegrationTest;


class ResourceAccessTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__);
        $dotenv->load();
    }

    public function testGetResource()
    {
        $apiKey = getenv('API_KEY');
        $secretKey = getenv('API_SECRET');

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\StreamHandler('php://stdout'));

        $connection = new \iMoneza\Connection($apiKey, $secretKey, new \iMoneza\Request\Curl(), $logger);

        $connection->setBaseURLAccessAPI(getenv('API_URL')); // only for testing

        $options = new \iMoneza\Options\Access\Resource();
        $options->setAccessKey($apiKey)->setResourceKey('81')
            ->setResourceURL('http://imonezajournal.com/2015/02/02/candidate-visits-local-business/');

        $result = $connection->request($options);

        $this->assertTrue($result);
    }
}