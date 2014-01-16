<?php

namespace Databox\Tests;

use Databox\DataboxClient;
use Databox\DataboxBuilder;
use Guzzle\Log\ClosureLogAdapter;
use Guzzle\Plugin\Log\LogPlugin;
use Guzzle\Log\MessageFormatter;

class DataboxTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DataboxClient
     */
    protected $client;

    /**
     * @var DataboxBuilder
     */
    protected $builder;

    public function setUp()
    {
        $this->client = new DataboxClient('https://app.databox.com/');
        $this->client->setApiKey('3c2pfw95lm80og0w4wgw08ccgwgo08sg');
        $this->client->setUniqueUrl('p6a50fl7nkg84400');
        
        $adapter = new ClosureLogAdapter(function ($m) { file_put_contents('trace.log',$m,\FILE_APPEND); });
        $logPlugin = new LogPlugin($adapter, MessageFormatter::DEBUG_FORMAT);
        $this->client->addSubscriber($logPlugin);

        $this->builder = new DataboxBuilder();
    }
}
