<?php
namespace Databox\Widget\Table;

class ColumnData
{

    /**
     * Column value.
     *
     * @var string int float
     */
    protected $value;

    /**
     * Column change.
     *
     * @var string int float
     */
    protected $change;

    /**
     * Format
     *
     * @var string
     */
    protected $format;

    /**
     * Change Format
     *
     * @var string
     */
    protected $change_format;

    /**
     * ColumnData constructor
     *
     * @param string|int|float $value
     *            Value
     * @param string|int|float $change
     *            Change
     * @param string $format
     *            Format
     */
    public function __construct($value, $change = "", $format = "", $changeFormat = "")
    {
        $this->value = $value;
        $this->change = $change;
        $this->format = $format;
        $this->change_format = $changeFormat;
    }

    /**
     * Getter for value.
     *
     * @return string int float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Getter for change.
     *
     * @return string int float
     */
    public function getChange()
    {
        return $this->change;
    }

    /**
     * Getter for format.
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Format that is applied for change in the table.
     * 
     * @return string
     */
    public function getChangeFormat()
    {
        return $this->change_format;
    }
}
