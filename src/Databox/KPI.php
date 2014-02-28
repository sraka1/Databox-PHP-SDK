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
     * The prescribed date format
     */
    const DATE_FORMAT = 'Y-m-d\TH:i:s';

    public function __construct($key, $value, $date = null)
    {
        $this->key = $key;
        $this->value = json_encode($value);
        if (is_null($date) || ! ($date instanceof \DateTime)) {
            $UTC = new \DateTimeZone("UTC");
            $date = new \DateTime("now", $UTC);
        }
        $this->date = $date->format(self::DATE_FORMAT);
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
        json_decode($string);
        if (json_last_error() == JSON_ERROR_NONE) {
            return json_decode($this->value);    
        } else {
            return $this->value;
        }
        
    }

    public function setValue($value)
    {
        $this->value = json_encode($value);
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }
}

?>