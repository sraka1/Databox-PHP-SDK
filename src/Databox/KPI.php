<?php
namespace Databox;

/**
 *
 * @author Uros Majeric
 *
 */
class KPI
{

    /**
     * Name of key
     * @var string
     */
    public $key;

    /**
     * Set value
     * @var string
     */
    public $value;

    /**
     * Set date
     * @var DateTime
     */
    public $date;

    /**
     *
     * @var string
     */
    public $operation;

    /**
     * The prescribed date format
     */
    const DATE_FORMAT = 'Y-m-d\TH:i:s';

    public function __construct($key, $value, $date = null, $metricOperation = null)
    {
        $this->key = $key;
        $this->value = $value;
        if (is_null($date) || ! ($date instanceof \DateTime)) {
            $UTC = new \DateTimeZone("UTC");
            $date = new \DateTime("now", $UTC);
        }
        $this->date = $date->format(self::DATE_FORMAT);
        if (! is_null($metricOperation)) {
            if (in_array($metricOperation, [
                'None',
                'Sum'
            ])) {
                $this->operation = $metricOperation;
            }
        }
    }

    /**
     * Gets the key
     * @return string The key.
     */
    public function getKey()
    {
        return $key;
    }

    /**
     * Sets the key
     * @param string $key The key to be set
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Gets the value
     * @return string The value.
     */
    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getMetricOperation()
    {
        return $this->operation;
    }

    public function setMetricOperation(string $operation)
    {
        $this->operation = $operation;
    }

}

?>
