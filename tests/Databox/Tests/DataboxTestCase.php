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
        $this->client = $clientBuilder->setDataboxBaseUrl('https://dev.databox.com/')->setApiKey('4yot7fe2uhkwocw44kgwo048g8o8s8og')->build();
        
        $adapter = new ClosureLogAdapter(function ($m) { file_put_contents('trace.log',$m,\FILE_APPEND); });
        $logPlugin = new LogPlugin($adapter, MessageFormatter::DEBUG_FORMAT);
        $this->client->addSubscriber($logPlugin);

        $this->builder = new DataboxBuilder();
    }
}
