<?php
namespace Databox\Widget;

class Table
{

    /**
     * Class for Table data
     */
    protected $key;

    /**
     * Table columnds
     * @var array
     */
    protected $columns;

    /**
     * Table rows
     * @var array
     */
    protected $rows;

    /**
     * Allowed column types
     * @var array
     */
    protected $allowedTypes = ["int", "float", "date", "string"];

    public function __construct($key)
    {
        $this->columnns   = [];
        $this->rows       = [];
        $this->key        = $key;
    }

    public function addColumn($name, $type)
    {
        if (!in_array($type, $this->allowedTypes)) {
            throw new \InvalidArgumentException("Allowed table column types are: 'int', 'float', 'date' and 'string'");
        }
        $this->columns[] = [
            "name" => $name,
            "type" => $type
        ];
    }

    public function addRow()
    {
        $columnCount = func_num_args();
        if ($columnCount !== count($this->columns)) {
            throw new \InvalidArgumentException("Row column count does not match the number of instantiated columns.");
        }
        $columnDataArray  = func_get_args();
        foreach ($columnData as $columnDataItem) {
            if (!$columnDataItem instanceof \Databox\Table\ColumnData) {
                throw new \InvalidArgumentException("Data sets for columns must be initialized as \Databox\Table\ColumnData objects.");
            }
            $rowData[] = $columnDataItem->getValue();
            $changeData[] = $columnDataItem->getChange();
            $formatData[] = $columnDataItem->getFormat();
        }
        $this->rows[] = ["row" => $rowData, "change" => $changeData, "format" => $formatData];
    }

    public function addData(\Databox\DataboxBuilder $builder)
    {
        $builder->addKpi($this->key . "@columns", $this->columns);
        foreach ($this->rows as $i => $row) {
            $builder->addKpi($this->key . "@row_" . $i, $row["row"]);
            $builder->addKpi($this->key . "@change_" . $i, $row["change"]);
            $builder->addKpi($this->key . "@format_" . $i, $row["format"]);
        }
        return $builder->getRawPayload();
    }
}
