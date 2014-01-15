<?php
namespace Databox;

use \DateTime;
use \DateTimeZone;

/**
 * Class for building JSON request for Databox
 */
class DataboxBuilder
{

    /**
     *
     * @var string APIKey required for authenticationg to custom connection
     */
    private $apiKey;

    /**
     *
     * @var string APP-ID required for authenticationg to custom connection
     */
    private $appId;

    /**
     * JSON array holder
     *
     * @var array
     */
    protected $JSON;

    /**
     * Builder constructor
     */
    public function __construct($apiKey, $appId)
    {
        $this->apiKey = $apiKey;
        $this->appId = $appId;
        $this->JSON = [];
    }

    /**
     * Add a trivial KPI
     *
     * @param string $key
     *            KPI key, as set up in the Databox web app.
     * @param mixed $value
     *            The value
     * @param string $date
     *            Optional date, otherwise current time will be used.
     */
    public function addKpi($key, $value, $date = null)
    {
        if (is_null($date)) {
            $UTC = new DateTimeZone("UTC");
            $date = new DateTime("now", $UTC);
            $date = $date->format('Y-m-d\TH:i:s');
        }
        $this->JSON['data'][] = [
            "key" => $key,
            "value" => $value,
            "date" => $date
        ];
    }
    
    /**
     * @return boolean true if there was no KPI added to this builder, false otherwise.
     */
    public function isEmpty()
    {
        return empty($this->JSON);
    }

    /**
     * Add widget object to current payload.
     *
     * @param DataboxWidgetBase $widget
     *            Widget object.
     */
    public function addWidget(\Databox\Widget\Base $widget)
    {
        $this->JSON = $widget->addData($this);
    }

    /**
     * Returns the current payload in JSON format.
     *
     * @return string The payload.
     */
    public function getPayload()
    {
        $payload = json_encode($this->JSON);
        
        return $payload;
    }

    /**
     * Returns the current payload as a PHP array.
     *
     * @return array The payload.
     */
    public function getRawPayload()
    {
        $payload = $this->JSON;
        
        return $payload;
    }

    /**
     * Resets the builder so you can re-use the object.
     */
    public function reset()
    {
        $this->JSON = [];
    }

    /**
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     *
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }
}
