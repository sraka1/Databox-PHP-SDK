<?php
namespace Databox\Widget;

class Progress extends Base
{

    /**
     * Key of the Widget.
     * @var string
     */
    protected $key;

    /**
     * Maximum value
     * @var string
     */
    protected $max;

    /**
     * Label
     * @var string
     */
    protected $label;

    /**
     * Value
     * @var string
     */
    protected $value;

    /**
     * The date for submission
     * @var string
     */
    protected $date;

    /**
     * Initializes a Table object.
     * @param string $key  KPI key for the table.
     * @param string $date An optional timestamp for this data.
     */
    public function __construct($key, $date = NULL)
    {
        $this->key        = $key;
        if (!is_null($date)) {
            $this->date = $date;
        }
    }

    /**
     * Set max value.
     * @param string|int|float $max Set the max value.
     */
    public function setMax($max)
    {
        $this->max = $max;
    }

    /**
     * Set label.
     * @param string $label Set the label.
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Set current value.
     * @param string|int|float $max Set the max value.
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Returns a DataboxBuilder raw payload.
     * @param DataboxDataboxBuilder $builder Instance of DataboxBuilder.
     */
    public function addData(\Databox\DataboxBuilder $builder)
    {
        $builder->addKpi($this->key . "@labels", $this->label, ($this->date ? $this->date : NULL));
        $builder->addKpi($this->key . "@max", $this->max, ($this->date ? $this->date : NULL));
        $builder->addKpi($this->key, $this->value, ($this->date ? $this->date : NULL));
        return $builder->getRawPayload();
    }
}
