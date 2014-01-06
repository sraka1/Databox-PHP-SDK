<?php
namespace Databox\Widget;

class Pie
{

    /**
     * Class for Table data
     */
    protected $key;

    /**
     * Pie labels
     * @var array
     */
    protected $labels;

    /**
     * Pie slices
     * @var array
     */
    protected $slices;


    public function __construct($key)
    {
        $this->labels   = [];
        $this->slices   = [];
        $this->key        = $key;
    }

    public function addSlice($label, $value, $change = "")
    {
        $this->labels[] = $label;
        $this->slices[] = [
            "row" => $value,
            "change" => $change
        ];
    }

    public function addData(\Databox\DataboxBuilder $builder)
    {
        $builder->addKpi($this->key . "@labels", $this->label);
        foreach ($this->slices as $i => $slice) {
            $builder->addKpi($this->key . "@row_" . $i, $slice["row"]);
            $builder->addKpi($this->key . "@change_" . $i, $slice["change"]);
        }
        return $builder->getRawPayload();
    }
}
