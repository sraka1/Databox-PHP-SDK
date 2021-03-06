# Databox PHP SDK

[![Build Status](https://travis-ci.org/sraka1/Databox-PHP-SDK.png?branch=master)](https://travis-ci.org/sraka1/Databox-PHP-SDK) [![Latest Stable Version](https://poser.pugx.org/databox/databox-php-sdk/v/stable.png)](https://packagist.org/packages/databox/databox-php-sdk) [![Total Downloads](https://poser.pugx.org/databox/databox-php-sdk/downloads.png)](https://packagist.org/packages/databox/databox-php-sdk) [![Latest Unstable Version](https://poser.pugx.org/databox/databox-php-sdk/v/unstable.png)](https://packagist.org/packages/databox/databox-php-sdk) [![License](https://poser.pugx.org/databox/databox-php-sdk/license.png)](https://packagist.org/packages/databox/databox-php-sdk)

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
The first step to use `databox-php-sdk` is to download composer, if we don't have it already:

```bash
$ curl -s http://getcomposer.org/installer | php
```

Then we can add `databox-php-sdk` as a dependency:
```bash
$ composer.phar require databox/databox-php-sdk:1.*
```

> `databox-php-sdk` follows the PSR-0 convention for file structuring and class naming, which means you can easily integrate `databox-php-sdk` classloading in your own autoloader.

## Basic usage

```php
<?php

// This file is generated by Composer
require_once '../vendor/autoload.php';

use \Databox\DataboxClient;
use \Databox\DataboxClientBuilder;
use \Databox\DataboxException;
use \Databox\DataboxBuilder;
use \Guzzle\Common\Exception\RuntimeException;
use \Exception;
use \Databox\Widget as Widget;
use \Databox\Widget\Table as Table;
use \Databox\KPI as KPI;

// Read from Custom connection info in Databox WebApp (https://app.databox.com)
$userAccessToken = 'YOUR-USER-ACCESS-TOKEN';
$sourceToken     = 'YOUR-SOURCE-TOKEN';

//Instantiate the client
$client = new DataboxClient($userAccessToken);
$client->setSourceToken($sourceToken);

//Instantiate the builder
$builder = new DataboxBuilder();

//The addKpi method uses the accepts $key, $value, $date (in that order). Date should be a timestamp in the format Y-m-d\TH:i:s. Date may be NULL, in which case the current UTC time will be used.
$builder->addKpi(new KPI("testmain", mt_rand(1,600)));
$builder->addKpi(new KPI("testbignumber", mt_rand(1,600)));
$builder->addKpi(new KPI("testcompare", mt_rand(1,600)));
$builder->addKpi(new KPI("testcompare", mt_rand(1,600)));
$builder->addKpi(new KPI("testintervalvalues", mt_rand(1,600)));
$builder->addKpi(new KPI("testlinechart", mt_rand(1,600)));
$builder->addKpi(new KPI("testbarchart", mt_rand(1,600)));

$table = new Widget\Table("testtable");
$table->addColumn("KPI", "string");
$table->addColumn("Today", "float");
$table->addColumn("Yesterday", "float");
$table->addRow(new Table\ColumnData("Visitors"), new Table\ColumnData(1234, 567), new Table\ColumnData(9876, 123));
$builder->addWidget($table);

$progress = new Widget\Progress("testprogress");
$progress->setMax(123);
$progress->setLabel("Life achievements");
$progress->setValue(10);
$builder->addWidget($progress);

$messages = new Widget\Messages("testmessages");
$messages->addMessage("I like pie!", "USD");
$messages->addMessage("Sweden", "USD");
$builder->addWidget($messages);

$pie = new Widget\Pie("testpie");
$pie->addSlice("Pepperoni", 20);
$pie->addSlice("Salami", 50, -10);
$pie->addSlice("Tuna", 70, -30);
$builder->addWidget($pie);

$funnel = new Widget\Funnel("testfunnel");
$funnel->addSlice("Cheese", 5);
$funnel->addSlice("Meat", 90, -10);
$funnel->addSlice("Apples", 10, -30);
$builder->addWidget($funnel);

$pipeline = new Widget\Pipeline("testpipeline");
$pipeline->addSlice("Mac", 20, 24);
$pipeline->addSlice("PC", 30, -10);
$pipeline->addSlice("Amiga", 10, -10);
$builder->addWidget($pipeline);

//You must provide uniqueURL and payload parameters. Payload can be any JSON string, but we reccommend you use our builder class.
try {
    //If no Exception is raised everything went through as it should've :)
    $returnedResult = $client->pushData($builder);
    
    is_array($returnedResult)
        ? print_r($returnedResult)
        : print($returnedResult);
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

//Fetch the saved data log
$log = $client->getPushLog();

echo $log;

```



## Documentation

See the `doc` directory for more detailed documentation. 

## License

`databox-php-sdk` is licensed under the MIT License - see the LICENSE file for details

## Credits

### Contributors

- The Databox team, most importantly [Jakob Murko aka. sraka1](http://github.com/sraka1) 
