<?php

namespace Databox\Tests;

use Databox\DataboxClient;
use Databox\DataboxBuilder;
use Guzzle\Log\ClosureLogAdapter;
use Guzzle\Plugin\Log\LogPlugin;
use Guzzle\Log\MessageFormatter;
use Databox\DataboxClientBuilder;

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
        $clientBuilder = new DataboxClientBuilder();
        $this->client = $clientBuilder->setApiKey('5dc5qvbnb9wcwogww8w0g8g8scgo4swg')->build();
        
        $adapter = new ClosureLogAdapter(function ($m) { file_put_contents('trace.log',$m,\FILE_APPEND); });
        $logPlugin = new LogPlugin($adapter, MessageFormatter::DEBUG_FORMAT);
        $this->client->addSubscriber($logPlugin);

        $this->builder = new DataboxBuilder();
    }
}
