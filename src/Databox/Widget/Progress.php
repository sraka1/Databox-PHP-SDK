<?php
namespace Databox\Widget;

class Progress extends Base
{

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
     * Returns DataboxBuilder's raw payload.
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