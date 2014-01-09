<?php
namespace Databox\Widget;

class Pie extends Base
{

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
        $this->slices[] = [
            "row" => $value,
            "change" => $change,
            "label"  => $label
        ];
    }

    /**
     * Returns a DataboxBuilder raw payload.
     * @param DataboxDataboxBuilder $builder Instance of DataboxBuilder.
     */
    public function addData(\Databox\DataboxBuilder $builder)
    {
        foreach ($this->slices as $i => $slice) {
            $key      = $this->key . "@row_" . $i;
            $builder->addKpi($key, $slice["row"], ($this->date ? $this->date : NULL));
            $labels[$key]  = $slice["label"];
            $changes[$key] = $slice["change"];
        }
        $builder->addKpi($this->key . "@labels", $labels, ($this->date ? $this->date : NULL));
        $builder->addKpi($this->key . "@changes", $changes, ($this->date ? $this->date : NULL));

        return $builder->getRawPayload();
    }
}
