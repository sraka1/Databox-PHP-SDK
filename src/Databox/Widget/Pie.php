<?php
namespace Databox\Widget;

use \Databox\KPI as KPI;

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
     * Returns KPI response array
     */
    public function getData()
    {
        $response = [];
        $response[] = new KPI($this->key . "@labels", $this->labels, ($this->date ? $this->date : NULL));
        $response[] = new KPI($this->key . "@values", $this->values, ($this->date ? $this->date : NULL));
        $response[] = new KPI($this->key . "@changes", $this->changes, ($this->date ? $this->date : NULL));
        return $response;
    }
}
