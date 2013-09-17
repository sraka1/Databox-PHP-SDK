<?php

namespace Databox\Tests;

class BuilderTest extends DataboxTestCase
{
    public function testCreate()
    {
        $this->builder->addKpi("milan", 150, "2013-09-17T23:15:18");
        $this->builder->addKpi("kucan", 250, "2013-07-30T22:55:00");

        $this->assertEquals('{"data":[{"key":"milan","value":150,"date":"2013-09-17T23:15:18"},{"key":"kucan","value":250,"date":"2013-07-30T22:55:00"}]}', $this->builder->getPayload());
    }

    /**
     * @depends testPushData
     */
    public function testReset()
    {
        $this->builder->reset();
        $this->assertEquals('[]', $this->builder->getPayload());
    }
}
