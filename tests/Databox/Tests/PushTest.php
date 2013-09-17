<?php

namespace Databox\Tests;

class PushTest extends DataboxTestCase
{
    public function testPushData()
    {
        $this->builder->addKpi("myKey", 123);
        $this->builder->addKpi("myExtraKey", 300, "2013-07-30T22:53:00");

        $res = $this->client->setPushData([
        'uniqueUrl' => 'leURL125',
        'payload'   => $this->builder->getPayload()
        ]);
        $this->assertTrue($res->hasKey('response'));
        $this->assertEquals('OK',$res->get('response')['type']);

    }

    /**
     * @depends testPushData
     */
    public function testGetPushLog($id)
    {
        $result = $this->client->getPushDataLog();

        $this->assertTrue($res->hasKey('response'));
    }
}
