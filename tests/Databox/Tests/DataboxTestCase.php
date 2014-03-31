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
        $this->client->setApiKey('2fvbxy97j1wkccgw44sk0o44wk0w4kgk'); // username: test@databox.com pw: test123 connection: PHP SDK Test
        $this->client->setUniqueUrl('32lkojmk5sw08o44');
        
        $adapter = new ClosureLogAdapter(function ($m) { file_put_contents('trace.log',$m,\FILE_APPEND); });
        $logPlugin = new LogPlugin($adapter, MessageFormatter::DEBUG_FORMAT);
        $this->client->addSubscriber($logPlugin);

        $this->builder = new DataboxBuilder();
    }
}
