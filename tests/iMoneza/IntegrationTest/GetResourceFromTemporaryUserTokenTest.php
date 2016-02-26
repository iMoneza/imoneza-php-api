<?php
/**
 * Tests getting the resource from the user token
 *
 * @author Aaron Saray
 * @todo get this to run one time successfully
 */

namespace iMoneza\IntegrationTest;


use iMoneza\Helper;

class GetResourceFromTemporaryUserTokenTest extends \PHPUnit_Framework_TestCase
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
        $accessApiKey = getenv('ACCESS_API_KEY');
        $accessSecretKey = getenv('ACCESS_API_SECRET');
        $apiKey = getenv('MANAGEMENT_API_KEY');
        $secretKey = getenv('MANAGEMENT_API_SECRET');

        $logger = new \Monolog\Logger('test');
        $logger->pushHandler(new \Monolog\Handler\StreamHandler('php://stdout'));

        $this->connection = new \iMoneza\Connection($apiKey, $secretKey, $accessApiKey, $accessSecretKey, new \iMoneza\Request\Curl(), $logger);
    }

    public function testGetResourceFromTemporaryUserToken()
    {
        $options = new \iMoneza\Options\Access\GetResourceFromTemporaryUserToken();
        $options->setApiBaseURL(getenv('ACCESS_API_URL')); // only for testing
        $options->setResourceKey('x')->setIP(Helper::getCurrentIP())
            ->setResourceURL('x')->setTemporaryUserToken("|635920927109906943|");

        $result = $this->connection->request($options, $options->getDataObject());

        $this->assertNotEmpty($result);
        $this->assertInstanceOf('\iMoneza\Data\ResourceAccess', $result);
    }
}