<?php
namespace Databox\Widget;

class Table extends Base
{

    /**
     * Table columnds
     * @var array
     */
    protected $columns = [];

    /**
     * Table rows
     * @var array
     */
    protected $rows = [];

    /**
     * Table changes
     * @var array
     */
    protected $changes = [];

    /**
     * Table formats
     * @var array
     */
    protected $formats = [];

    /**
     * Table column orders
     * @var array
     */
    protected $orderBy = [];

    /**
     * Adds a column to the table
     * @param string $name Column name
     * @param string $type Column type
     */
    public function addColumn($name, $orderBy = "", $deleteIfEmpty = TRUE)
    {
        $this->columns[] = $name;
        $this->orderBy[] = $orderBy;
    }

    /**
     * @param \Databox\Widget\Table\ColumnData $columnDataOne,... Series of ColumnData objects. Number must match the number of columns.
     */
    public function addRow()
    {
        $columnCount = func_num_args();
        if ($columnCount !== count($this->columns)) {
            throw new \InvalidArgumentException("Row column count does not match the number of instantiated columns.");
        }
        $columnDataArray  = func_get_args();
        foreach ($columnDataArray as $columnDataItem) {
            if (!$columnDataItem instanceof \Databox\Widget\Table\ColumnData) {
                throw new \InvalidArgumentException("Data sets for columns must be initialized as \Databox\Widget\Table\ColumnData objects.");
            }
            $rowData[] = $columnDataItem->getValue();
            $changeData[] = $columnDataItem->getChange();
            $formatData[] = $columnDataItem->getFormat();
        }
        $this->rows[] = $rowData;
        $this->changes[] = $changeData;
        $this->formats[] = $formatData;
    }
    
    /**
     * Returns a DataboxBuilder raw payload.
     * @param DataboxDataboxBuilder $builder Instance of DataboxBuilder.
     */
    public function addData(\Databox\DataboxBuilder $builder)
    {
        $builder->addKpi($this->key . "@columns", $this->columns, ($this->date ? $this->date : NULL));
        $builder->addKpi($this->key . "@rows", $this->rows, ($this->date ? $this->date : NULL));
        $builder->addKpi($this->key . "@changes", $this->changes, ($this->date ? $this->date : NULL));
        $builder->addKpi($this->key . "@formats", $this->formats, ($this->date ? $this->date : NULL));
        $builder->addKpi($this->key . "@order_by", $this->orderBy, ($this->date ? $this->date : NULL));
        return $builder->getRawPayload();
    }
    
    /**
     * Method removes all columns with no data
     */
    public function removeEmptyColumns()
    {
        /* First search for all empty columns */
        $emptyColumns = $this->findEmptyColumns();
        /* iterate all columns */
        for ($i = count($this->columns) - 1; $i >= 0; $i --) {
            /* if column is empty then remove it from columns and rows */
            if (in_array($i, $emptyColumns)) {
                unset($this->columns[$i]);
                foreach ($this->rows as &$row) {
                    unset($row['row'][$i]);
                    unset($row['change'][$i]);
                    unset($row['format'][$i]);
                }
            }
        }
    }
    
    /**
     * Method searches for all columns that have all cells empty.
     *
     * @return multitype:number
     */
    private function findEmptyColumns()
    {
        $emptyColumnIndexes = array();
        for ($i = 0; $i < count($this->columns); $i ++) {
            $isEmpty = true;
            foreach ($this->rows as $row) {
                if (! is_null($row['row'][$i])) {
                    $isEmpty = false;
                    break;
                }
            }
            if ($isEmpty) {
                $emptyColumnIndexes[] = $i;
            }
        }
        return $emptyColumnIndexes;
    }
}
