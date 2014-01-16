<?php
namespace Databox\Tests;

use Databox\KPI;

class PushTest extends DataboxTestCase
{

    public function testPushData()
    {
        $this->builder->addKpi(new KPI("myKey", 123));
        $this->builder->addKpi(new KPI("myExtraKey", 300, new \DateTime("2013-07-30 22:53:00")));

        $messages = new \Databox\Widget\Messages("testMessages", new \DateTime("2013-09-17 23:15:18"));
        $messages->addMessage("I like pie!");
        $messages->addMessage("Sweden");
        $this->builder->addWidget($messages);

        $pie = new \Databox\Widget\Pie("testPie", new \DateTime("2013-09-17 23:15:18"));
        $pie->addSlice("Pepperoni", 20);
        $pie->addSlice("Salami", 50, -10);
        $pie->addSlice("Tuna", 70, -30);
        $this->builder->addWidget($pie);
        
        $res = $this->client->pushData($this->builder);
        
        $this->assertTrue($res->hasKey('response'));
        $this->assertEquals('success', $res->get('response')['type']);
    }

    public function testGetPushLog()
    {
        $result = $this->client->getPushLog();
        
        $this->assertTrue(isset($result[0]['time']));
    }
}
