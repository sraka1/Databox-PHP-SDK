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
    public function __construct()
    {
        $this->JSON = [];
        $this->JSON['data'] = [];
    }

    /**
     * Add trivial KPI
     * @param KPI $kpi The object
     */
    public function addKpi(KPI $kpi)
    {
        $this->JSON['data'][] = $kpi;
    }

    /**
     * Add multiple KPIS to the data array
     * @param array $kpis Collection of KPIs.
     */
    public function addKpis($kpis)
    {
        $this->JSON['data'] = array_merge($this->JSON['data'], $kpis);
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
        $this->addKpis($widget->getData());
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

}
