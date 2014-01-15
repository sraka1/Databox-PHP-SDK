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
     * Allowed column types
     * @var array
     */
    protected $allowedTypes = ["int", "float", "date", "string"];

    /**
     * Adds a column to the table
     * @param string $name Column name
     * @param string $type Column type
     */
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
        $this->rows[] = ["row" => $rowData, "change" => $changeData, "format" => $formatData];
    }
    
    /**
     * Returns a DataboxBuilder raw payload.
     * @param DataboxDataboxBuilder $builder Instance of DataboxBuilder.
     */
    public function addData(\Databox\DataboxBuilder $builder)
    {
        $builder->addKpi($this->key . "@columns", $this->columns, ($this->date ? $this->date : NULL));
        foreach ($this->rows as $i => $row) {
            $builder->addKpi($this->key . "@row_" . $i, $row["row"], ($this->date ? $this->date : NULL));
            $builder->addKpi($this->key . "@change_" . $i, $row["change"], ($this->date ? $this->date : NULL));
            $builder->addKpi($this->key . "@format_" . $i, $row["format"], ($this->date ? $this->date : NULL));
        }
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
        /* reindex rows and columns so that they are no longer associative arrays (which becomes because of removing items) */
        foreach ($this->rows as &$row) {
            $row['row'] = array_values($row['row']);
            $row['change'] = array_values($row['change']);
            $row['format'] = array_values($row['format']);
        }
        $this->columns = array_values($this->columns);
    }

    /**
     * Method searches for all columns that have all cells empty.
     *
     * @return multitype:number
     */
    private function findEmptyColumns()
    {
        $emptyColumnIndexes = array();
        /* iterate all columns - skip first one (label column) */
        for ($i = 1; $i < count($this->columns); $i ++) {
            $isEmpty = true;
            foreach ($this->rows as $row) {
            $rowValue = $row['row'][$i];
                if (! is_null($rowValue) && isset($rowValue) && ! empty($rowValue) && is_numeric($rowValue)) {
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
