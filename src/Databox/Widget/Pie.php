<?php
namespace Databox\Widget;

class Pie extends Base
{

    /**
     * Pie labels
     * @var array
     */
    protected $labels = [];

    /**
     * Pie values
     * @var array
     */
    protected $values = [];

    /**
     * Pie changes
     * @var array
     */
    protected $changes = [];

    /**
     * Add a Pie/Funnel/Pipeline slice.
     * @param string $label  The label of the slice.
     * @param string|int|float $value  The value of the slice.
     * @param string $change The change property of the value. Optional.
     */
    public function addSlice($label, $value, $change = "")
    {
        $this->labels[]  = $label;
        $this->values[]  = $value;
        $this->changes[] = $change;
    }

    /**
     * Returns a DataboxBuilder raw payload.
     * @param DataboxDataboxBuilder $builder Instance of DataboxBuilder.
     */
    public function addData(\Databox\DataboxBuilder $builder)
    {
        $builder->addKpi($this->key . "@labels", $this->labels, ($this->date ? $this->date : NULL));
        $builder->addKpi($this->key . "@values", $this->values, ($this->date ? $this->date : NULL));
        $builder->addKpi($this->key . "@changes", $this->changes, ($this->date ? $this->date : NULL));

        return $builder->getRawPayload();
    }
}
