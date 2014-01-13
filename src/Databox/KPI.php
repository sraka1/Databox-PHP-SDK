<?php
namespace Databox;

/**
 *
 * @author Uros Majeric
 *        
 */
class KPI
{

    private $key;

    private $value;

    private $date;

    /**
     * Constructor is private by default.
     * Use KPI builder to create new instance.
     */
    function __construct($key, $value, $date = null)
    {
        $this->key = $key;
        $this->value = $value;
        $this->date = $date;
    }

    public function getKey()
    {
        return $key;
    }

    public function setKey($key)
    
    {
        $this->key = $key;
    }

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
}

?>