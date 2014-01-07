<?php

namespace Databox\Widget;

abstract class Base 
{
	/**
     * Key of the Widget.
     * @var string
     */
    protected $key;

    /**
     * The date for submission
     * @var string
     */
    protected $date;

    /**
     * Initializes a Widget object.
     * @param string $key  KPI key for the table.
     * @param string $date An optional timestamp for this data.
     */
    public function __construct($key, $date = NULL)
    {
        $this->key        = $key;
        if (!is_null($date)) {
            $this->date = $date;
        }
    }

    /**
     * addData returns the data array produced by the widget
     * @param DataboxDataboxBuilder $builder DataboxBuilder instance
     */
    abstract public function addData(\Databox\DataboxBuilder $builder);

}