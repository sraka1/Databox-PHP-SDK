<?php
namespace Databox;

use \DateTime;
use \DateTimeZone;

class DataboxBuilder
{

    const DATE_TIME_FORMAT = 'Y-m-d\TH:i:s';

    /**
     * Class for building JSON request for Databox
     */
    protected $JSON;

    public function __construct()
    {
        $this->JSON = [];
    }

    public function addKpi($key, $value, $date = null)
    {
        if (is_null($date)) {
            $UTC = new DateTimeZone("UTC");
            $date = new DateTime("now", $UTC);
            $date = $date->format(DATE_TIME_FORMAT);
        }
        $this->JSON['data'][] = [
            "key" => $key,
            "value" => $value,
            "date" => $date
        ];
    }

    public function getPayload()
    {
        $payload = json_encode($this->JSON);
        
        return $payload;
    }

    public function reset()
    {
        $this->JSON = [];
    }
}
