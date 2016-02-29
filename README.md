# iMoneza PHP API
A PHP library to integrate iMoneza into your application.

Using your <http://imoneza.com> account, you can interact with all parts of the API using this library.  This library
requires PHP 5.4+ and curl to be installed.

## Installation

This library is available on packagist and can be installed using composer.

```bash
$ composer require imoneza/imoneza-php-api
```

## Basic Usage

There are a number of ways to interact with the API.  But, the way of performing each task is relatively the same.  For 
this example, let's save a resource to iMoneza.

```PHP
$options = new \iMoneza\Options\Management\SaveResource();
$options->setExternalKey('announcement-wisconsin-crowned-king-of-cheese')
    ->setName('Wisconsin Crowned King of Cheese')
    ->setTitle('Wisconsin Crowned King of Cheese')
    ->setPricingGroupId('aaa111bb-22cc-425f-425f-aaa111bb452d');

$logger = new \Monolog\Logger('iMoneza');
$connection = new \iMoneza\Connection($apiKey, $secretKey, $accessApiKey, $accessSecretKey, new \iMoneza\Request\Curl(), $logger);
$connection->request($options, new \iMoneza\Data\None());
```

## Documentation

[Introduction](docs/01-intro.md)  
[The Connection Object](docs/02-connection.md)  
[Options Objects](docs/03-options.md)  
[Data Objects](docs/04-data.md)  
[Examples](docs/05-examples.md)  
  
## About

### Requirements

 - PHP 5.4+
 - Curl
 - iMoneza publisher account
 
### Bugs and Feature Requests

Bugs and feature request are tracked on [GitHub](https://github.com/iMoneza/imoneza-php-api/issues)

### Author

[iMoneza, LLC](https://imoneza.com)

#### Contributors

[Aaron Saray](https://github.com/aaronsaray)

### License

This library is licensed under the LGPLv3 License - see the [LICENSE](LICENSE) file for details

