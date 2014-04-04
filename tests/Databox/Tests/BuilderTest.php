<?php

namespace Databox\Tests;

use Databox\Widget as Widget;
use Databox\KPI as KPI;
use Databox\Widget\Table as Table;

class BuilderTest extends DataboxTestCase
{
    public function testCreate()
    {
        $this->builder->addKpi(new KPI("milan", 150, new \DateTime("2013-09-17 23:15:18")));
        $this->builder->addKpi(new KPI("kucan", 250, new \DateTime("2013-07-30 22:55:00")));

        $this->assertEquals('{"data":[{"key":"milan","value":"150","date":"2013-09-17T23:15:18","operation":null},{"key":"kucan","value":"250","date":"2013-07-30T22:55:00","operation":null}]}', $this->builder->getPayload());
    }

    public function testCreateWidgets()
    {
        $table = new Widget\Table("testtable", new \DateTime("2013-09-17T23:15:18"));
        $table->addColumn("KPI", "string");
        $table->addColumn("Today", "float");
        $table->addColumn("Yesterday", "float");
        $table->addRow(new Table\ColumnData("Visitors"), new Table\ColumnData(1234, 567), new Table\ColumnData(9876, 123));
        $this->builder->addWidget($table);

        $progress = new Widget\Progress("testprogress", new \DateTime("2013-09-17T23:15:18"));
        $progress->setMax(123);
        $progress->setLabel("Life achievements");
        $progress->setValue(10);
        $this->builder->addWidget($progress);

        $messages = new Widget\Messages("testmessages", new \DateTime("2013-09-17T23:15:18"));
        $messages->addMessage("I like pie!", "Number");
        $messages->addMessage("Sweden", "USD");
        $this->builder->addWidget($messages);

        $pie = new Widget\Pie("testpie", new \DateTime("2013-09-17T23:15:18"));
        $pie->addSlice("Pepperoni", 20);
        $pie->addSlice("Salami", 50, -10);
        $pie->addSlice("Tuna", 70, -30);
        $this->builder->addWidget($pie);

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

        $this->builder->addKpi(new KPI("Nixon", 170, new \DateTime("2013-09-17T23:15:18")));
        //var_dump($this->builder->getPayload()); exit;

        $this->assertEquals('{"data":[{"key":"testtable@columns","value":"[\"KPI\",\"Today\",\"Yesterday\"]","date":"2013-09-17T23:15:18","operation":null},{"key":"testtable@rows","value":"[[\"Visitors\",1234,9876]]","date":"2013-09-17T23:15:18","operation":null},{"key":"testtable@changes","value":"[[\"\",567,123]]","date":"2013-09-17T23:15:18","operation":null},{"key":"testtable@changes_formats","value":"[[\"\",\"\",\"\"]]","date":"2013-09-17T23:15:18","operation":null},{"key":"testtable@formats","value":"[[\"\",\"\",\"\"]]","date":"2013-09-17T23:15:18","operation":null},{"key":"testtable@order_by","value":"[\"string\",\"float\",\"float\"]","date":"2013-09-17T23:15:18","operation":null},{"key":"testprogress@label","value":"\"Life achievements\"","date":"2013-09-17T23:15:18","operation":null},{"key":"testprogress@max_value","value":"123","date":"2013-09-17T23:15:18","operation":null},{"key":"testprogress","value":"10","date":"2013-09-17T23:15:18","operation":null},{"key":"testmessages@labels","value":"[\"I like pie!\",\"Sweden\"]","date":"2013-09-17T23:15:18","operation":null},{"key":"testmessages@icons","value":"[\"Number\",\"USD\"]","date":"2013-09-17T23:15:18","operation":null},{"key":"testpie@labels","value":"[\"Pepperoni\",\"Salami\",\"Tuna\"]","date":"2013-09-17T23:15:18","operation":null},{"key":"testpie@values","value":"[20,50,70]","date":"2013-09-17T23:15:18","operation":null},{"key":"testpie@changes","value":"[\"\",-10,-30]","date":"2013-09-17T23:15:18","operation":null},{"key":"testfunnel@labels","value":"[\"Cheese\",\"Meat\",\"Apples\"]","date":"2013-09-17T23:15:18","operation":null},{"key":"testfunnel@values","value":"[5,90,10]","date":"2013-09-17T23:15:18","operation":null},{"key":"testfunnel@changes","value":"[\"\",-10,-30]","date":"2013-09-17T23:15:18","operation":null},{"key":"testpipeline@labels","value":"[\"Mac\",\"PC\",\"Amiga\"]","date":"2013-09-17T23:15:18","operation":null},{"key":"testpipeline@values","value":"[20,30,10]","date":"2013-09-17T23:15:18","operation":null},{"key":"testpipeline@changes","value":"[24,-10,-10]","date":"2013-09-17T23:15:18","operation":null},{"key":"Nixon","value":"170","date":"2013-09-17T23:15:18","operation":null}]}', $this->builder->getPayload());

    }

    public function testReset()
    {
        $this->builder->reset();
        $this->assertEquals('[]', $this->builder->getPayload());
    }
}
