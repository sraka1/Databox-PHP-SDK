<?php
namespace Databox\Widget\Table;

class ColumnData
{

    /**
     * Value
     */
    protected $value;

    /**
     * Change
     */
    protected $change;

    /**
     * Format
     * @var string
     */
    protected $format;

    public function __construct($value, $change, $format)
    {
        $this->value  = $value;
        $this->change = $change;
        $this->format = $format;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getChange()
    {
        return $this->change;
    }

    public function getFormat()
    {
        return $this->format;
    }
}
