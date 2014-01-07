<?php

namespace Databox\Tests;

use Databox\Widget as Widget;
use Databox\Widget\Table as Table;

class BuilderTest extends DataboxTestCase
{
    public function testCreate()
    {
        $this->builder->addKpi("milan", 150, "2013-09-17T23:15:18");
        $this->builder->addKpi("kucan", 250, "2013-07-30T22:55:00");

        $this->assertEquals('{"data":[{"key":"milan","value":150,"date":"2013-09-17T23:15:18"},{"key":"kucan","value":250,"date":"2013-07-30T22:55:00"}]}', $this->builder->getPayload());
    }

    public function testCreateWidgets()
    {
        $table = new Widget\Table("testTable", "2013-09-17T23:15:18");
        $table->addColumn("KPI", "string");
        $table->addColumn("Today", "float");
        $table->addColumn("Yesterday", "float");
        $table->addRow(new Table\ColumnData("Visitors"), new Table\ColumnData(1234, 567), new Table\ColumnData(9876, 123));
        $this->builder->addWidget($table);

        $progress = new Widget\Progress("testProgress", "2013-09-17T23:15:18");
        $progress->setMax(123);
        $progress->setLabel("Life achievements");
        $progress->setValue(10);
        $this->builder->addWidget($progress);

        $messages = new Widget\Messages("testMessages", "2013-09-17T23:15:18");
        $messages->addMessage("I like pie!");
        $messages->addMessage("Sweden");
        $this->builder->addWidget($messages);

        $pie = new Widget\Pie("testPie", "2013-09-17T23:15:18");
        $pie->addSlice("Pepperoni", 20);
        $pie->addSlice("Salami", 50, -10);
        $pie->addSlice("Tuna", 70, -30);
        $this->builder->addWidget($pie);

        $pie = new Widget\Funnel("testFunnel", "2013-09-17T23:15:18");
        $pie->addSlice("Cheese", 5);
        $pie->addSlice("Meat", 90, -10);
        $pie->addSlice("Apples", 10, -30);
        $this->builder->addWidget($pie);

        $pie = new Widget\Pipeline("testPipeline", "2013-09-17T23:15:18");
        $pie->addSlice("Mac", 20, 24);
        $pie->addSlice("PC", 30, -10);
        $pie->addSlice("Amiga", 10, -10);
        $this->builder->addWidget($pie);

        $this->builder->addKpi("Nixon", 170, "2013-09-17T23:15:18");

        $this->assertEquals('{"data":[{"key":"testTable@columns","value":[{"name":"KPI","type":"string"},{"name":"Today","type":"float"},{"name":"Yesterday","type":"float"}],"date":"2013-09-17T23:15:18"},{"key":"testTable@row_0","value":["Visitors",1234,9876],"date":"2013-09-17T23:15:18"},{"key":"testTable@change_0","value":["",567,123],"date":"2013-09-17T23:15:18"},{"key":"testTable@format_0","value":["","",""],"date":"2013-09-17T23:15:18"},{"key":"testProgress@labels","value":"Life achievements","date":"2013-09-17T23:15:18"},{"key":"testProgress@max","value":123,"date":"2013-09-17T23:15:18"},{"key":"testProgress","value":10,"date":"2013-09-17T23:15:18"},{"key":"testMessages@message_0","value":"I like pie!","date":"2013-09-17T23:15:18"},{"key":"testMessages@message_1","value":"Sweden","date":"2013-09-17T23:15:18"},{"key":"testPie@labels","value":["Pepperoni","Salami","Tuna"],"date":"2013-09-17T23:15:18"},{"key":"testPie@row_0","value":20,"date":"2013-09-17T23:15:18"},{"key":"testPie@change_0","value":"","date":"2013-09-17T23:15:18"},{"key":"testPie@row_1","value":50,"date":"2013-09-17T23:15:18"},{"key":"testPie@change_1","value":-10,"date":"2013-09-17T23:15:18"},{"key":"testPie@row_2","value":70,"date":"2013-09-17T23:15:18"},{"key":"testPie@change_2","value":-30,"date":"2013-09-17T23:15:18"},{"key":"testFunnel@labels","value":["Cheese","Meat","Apples"],"date":"2013-09-17T23:15:18"},{"key":"testFunnel@row_0","value":5,"date":"2013-09-17T23:15:18"},{"key":"testFunnel@change_0","value":"","date":"2013-09-17T23:15:18"},{"key":"testFunnel@row_1","value":90,"date":"2013-09-17T23:15:18"},{"key":"testFunnel@change_1","value":-10,"date":"2013-09-17T23:15:18"},{"key":"testFunnel@row_2","value":10,"date":"2013-09-17T23:15:18"},{"key":"testFunnel@change_2","value":-30,"date":"2013-09-17T23:15:18"},{"key":"testPipeline@labels","value":["Mac","PC","Amiga"],"date":"2013-09-17T23:15:18"},{"key":"testPipeline@row_0","value":20,"date":"2013-09-17T23:15:18"},{"key":"testPipeline@change_0","value":24,"date":"2013-09-17T23:15:18"},{"key":"testPipeline@row_1","value":30,"date":"2013-09-17T23:15:18"},{"key":"testPipeline@change_1","value":-10,"date":"2013-09-17T23:15:18"},{"key":"testPipeline@row_2","value":10,"date":"2013-09-17T23:15:18"},{"key":"testPipeline@change_2","value":-10,"date":"2013-09-17T23:15:18"},{"key":"Nixon","value":170,"date":"2013-09-17T23:15:18"}]}', $this->builder->getPayload());

    }

    public function testReset()
    {
        $this->builder->reset();
        $this->assertEquals('[]', $this->builder->getPayload());
    }
}
