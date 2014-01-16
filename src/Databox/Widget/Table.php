<?php
namespace Databox\Widget;

use \Databox\KPI as KPI;

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
     * Returns KPI response array
     */
    public function getData()
    {
        $response = [];
        $response[] = new KPI($this->key . "@columns", $this->columns, ($this->date ? $this->date : NULL));
        $response[] = new KPI($this->key . "@rows", $this->rows, ($this->date ? $this->date : NULL));
        $response[] = new KPI($this->key . "@changes", $this->changes, ($this->date ? $this->date : NULL));
        $response[] = new KPI($this->key . "@formats", $this->formats, ($this->date ? $this->date : NULL));
        $response[] = new KPI($this->key . "@order_by", $this->orderBy, ($this->date ? $this->date : NULL));
        return $response;
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
            /* if column is empty then remove it from columns and rows; Don't like this. MUST REFACTOR! */
            if (in_array($i, $emptyColumns)) {
                unset($this->columns[$i]);
                foreach ($this->rows as &$row) {
                    unset($row[$i]);
                }
                foreach ($this->changes as &$row) {
                    unset($row[$i]);
                }
                foreach ($this->formats as &$row) {
                    unset($row[$i]);
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
        $emptyColumnIndexes = [];
        for ($i = 0; $i < count($this->columns); $i++) {
            $isEmpty = true;
            foreach ($this->rows as $row) { //Don't like this. Lots of data -> lots of problems.
                if (!is_null($row[$i])) {
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
