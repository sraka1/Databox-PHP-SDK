<?php
namespace Databox\Widget;

class Progress
{

    /**
     * Key for specified KPI
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


    public function __construct($key)
    {
        $this->key        = $key;
    }

    public function setMax($max)
    {
        $this->max = $max;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function addData(\Databox\DataboxBuilder $builder)
    {
        $builder->addKpi($this->key . "@labels", $this->label);
        $builder->addKpi($this->key . "@max", $this->max);
        $builder->addKpi($this->key, $this->value);
        return $builder->getRawPayload();
    }
}
