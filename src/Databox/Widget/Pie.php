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
     * Pie slices
     * @var array
     */
    protected $slices = [];

    /**
     * Add a Pie/Funnel/Pipeline slice.
     * @param string $label  The label of the slice.
     * @param string|int|float $value  The value of the slice.
     * @param string $change The change property of the value. Optional.
     */
    public function addSlice($label, $value, $change = "")
    {
        $this->labels[] = $label;
        $this->slices[] = [
            "row" => $value,
            "change" => $change
        ];
    }

    /**
     * Returns a DataboxBuilder raw payload.
     * @param DataboxDataboxBuilder $builder Instance of DataboxBuilder.
     */
    public function addData(\Databox\DataboxBuilder $builder)
    {
        $builder->addKpi($this->key . "@labels", $this->labels, ($this->date ? $this->date : NULL));
        foreach ($this->slices as $i => $slice) {
            $builder->addKpi($this->key . "@row_" . $i, $slice["row"], ($this->date ? $this->date : NULL));
            $builder->addKpi($this->key . "@change_" . $i, $slice["change"], ($this->date ? $this->date : NULL));
        }
        return $builder->getRawPayload();
    }
}
