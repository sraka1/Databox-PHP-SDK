# Databox PHP SDK

[![Build Status](https://travis-ci.org/sraka1/Databox-PHP-SDK.png?branch=master)](https://travis-ci.org/sraka1/Databox-PHP-SDK)

The PHP SDK for interacting with the Databox Push API.

## Features

* Follows PSR-0 conventions and coding standard: autoload friendly
* Built on top of a solid and extensively tested framework - Guzzle
* Tested and well-documented

## Requirements

* PHP >= 5.3.3,
* Guzzle PHP library,
* (optional) PHPUnit to run tests.

## Autoloading

`databox-php-sdk` uses [Composer](http://getcomposer.org).
The first step to use `databox-php-sdk` is to download composer:

```bash
$ curl -s http://getcomposer.org/installer | php
```

Then we have to install our dependencies using:
```bash
$ php composer.phar install
```
Now we can use autoloader from Composer by:

```yaml
{
    "require": {
        "databox/databox-php-sdk": "*"
    },
    "minimum-stability": "dev"
}
```

> `databox-php-sdk` follows the PSR-0 convention names for its classes, which means you can easily integrate `databox-php-sdk` classes loading in your own autoloader.

## Basic usage of the `databox-php-sdk client

```php
<?php

// This file is generated by Composer
require_once 'vendor/autoload.php';

use \Databox\DataboxClient;
use \Databox\DataboxException;
use \Databox\DataboxBuilder;

// api_key is required, but if you intend to push to only one custom connection, you can add uniqueUrl aswell.

$clientBuilder = new DataboxClientBuilder();
$client = $clientBuilder->setApiKey('1234321')->build();

//Instantiate the builder
$builder = new DataboxBuilder();

//The addKpi method uses the accepts $key, $value, $date (in that order). Date should be a timestamp in the format Y-m-d\TH:i:s. Date may be NULL, in which case the current UTC time will be used.
$builder->addKpi("myKey", 123);
$builder->addKpi("myExtraKey", 300, "2013-07-30T22:53:00");

//You must provide uniqueURL and payload parameters. Payload can be any JSON string, but we reccommend you use our builder class.
try {
    $client->pushData($builder->getPayload(), 'leURL125');
} catch (DataboxException $e) {
    echo $e->getType();
    echo $e->getWebMessage();
    echo $e->getMessage();
} catch (RuntimeException $e) {
    echo $e->getMessage();
    echo $e->getCode();
} catch (Exception $e) {
    echo $e->getMessage();
} 

//You can reset the builder and reuse the same instance for pushing to a different custom app, if you want to.
$builder->reset();
$builder->addKpi("mySecondAppKey", 123);
$builder->addKpi("mySecondAppExtraKey", 300, "2013-07-30T22:53:00");

//Fetch the saved data log
$log = $client->getPushDataLog([
    'uniqueUrl' => '3rglns26g76sws04'
]);

echo $log;

```



## Documentation

See the `doc` directory for more detailed documentation. 

## License

`databox-php-sdk` is licensed under the MIT License - see the LICENSE file for details

## Credits

### Contributors

- The Databox team, most importantly [Jakob Murko aka. sraka1](http://github.com/sraka1) 
