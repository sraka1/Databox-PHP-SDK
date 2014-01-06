<?php
namespace Databox\Tests;

class PushTest extends DataboxTestCase
{

    public function testPushData()
    {
        $this->builder->addKpi("myKey", 123);
        $this->builder->addKpi("myExtraKey", 300, "2013-07-30T22:53:00");
        
        $res = $this->client->pushData($this->builder->getPayload(), '3rglns26g76sws04');
        
        $this->assertTrue($res->hasKey('response'));
        $this->assertEquals('success', $res->get('response')['type']);
    }

    public function testGetPushLog()
    {
        $result = $this->client->getPushDataLog([
            'uniqueUrl' => '3rglns26g76sws04'
        ]);
        
        $this->assertTrue(isset($result[0]['time']));
    }
}
