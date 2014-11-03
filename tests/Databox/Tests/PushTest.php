<?php
namespace Databox\Tests;

use Databox\Widget as Widget;
use Databox\KPI as KPI;
use Databox\Widget\Table as Table;

class PushTest extends DataboxTestCase
{
    protected function setUp()
    {
        $this->markTestSkipped('Test unavailable due to CA issues. Update to Guzzle 5 will fix this.');
    }

    public function testPushData()
    {
        $this->builder->addKpi(new KPI("testlinechart", 123));
        $this->builder->addKpi(new KPI("testbarchart", 300, new \DateTime("2013-07-30 22:53:00")));
        $this->builder->addKpi(new KPI("testmain", 300, new \DateTime("2013-07-30 22:53:00")));
        $this->builder->addKpi(new KPI("testbignumber", 123));
        $this->builder->addKpi(new KPI("testcompare", 300, new \DateTime("2013-07-30 22:53:00")));
        $this->builder->addKpi(new KPI("testintervalvalues", 300, new \DateTime("2013-07-30 22:53:00")));

        $messages = new Widget\Messages("testmessages", new \DateTime("2013-09-17 23:15:18"));
        $messages->addMessage("I like pie!", "Number");
        $messages->addMessage("Sweden", "USD");
        $this->builder->addWidget($messages);

        $pie = new Widget\Pie("testpie", new \DateTime("2013-09-17 23:15:18"));
        $pie->addSlice("Pepperoni", 20);
        $pie->addSlice("Salami", 50, -10);
        $pie->addSlice("Tuna", 70, -30);
        $this->builder->addWidget($pie);

        $table = new Widget\Table("testtable", new \DateTime("2013-09-17T23:15:18"));
        $table->addColumn("KPI", "string");
        $table->addColumn("Today", "float");
        $table->addColumn("Yesterday", "float");
        $table->addRow(new Table\ColumnData("Visitors"), new Table\ColumnData(1234, 567), new Table\ColumnData(9876, 123));
        $this->builder->addWidget($table);

        $pie = new Widget\Funnel("testfunnel", new \DateTime("2013-09-17T23:15:18"));
        $pie->addSlice("Cheese", 5);
        $pie->addSlice("Meat", 90, -10);
        $pie->addSlice("Apples", 10, -30);
        $this->builder->addWidget($pie);

        $pie = new Widget\Pipeline("testpipeline", new \DateTime("2013-09-17T23:15:18"));
        $pie->addSlice("Mac", 20, 24);
        $pie->addSlice("PC", 30, -10);
        $pie->addSlice("Amiga", 10, -10);
        $this->builder->addWidget($pie);

        $progress = new Widget\Progress("testprogress", new \DateTime("2013-09-17T23:15:18"));
        $progress->setMax(123);
        $progress->setLabel("Life achievements");
        $progress->setValue(10);
        $this->builder->addWidget($progress);
        
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
