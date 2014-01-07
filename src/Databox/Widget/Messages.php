<?php
namespace Databox\Widget;

class Messages extends Base
{

    /**
     * Key of the Widget.
     * @var string
     */
    protected $key;

    /**
     * Message array
     * @var array
     */
    protected $messages;

    /**
     * The date for submission
     * @var string
     */
    protected $date;

    /**
     * Initializes a Messages object.
     * @param string $key  KPI key for the table.
     * @param string $date An optional timestamp for this data.
     */
    public function __construct($key, $date = NULL)
    {
        $this->messages   = [];
        $this->key        = $key;
        if (!is_null($date)) {
            $this->date = $date;
        }
    }

    /**
     * Add a new message to the Messages widget
     * @param string $message The message to be added.
     */
    public function addMessage($message)
    {
        $this->messages[] = $message;
    }

    /**
     * Returns a DataboxBuilder raw payload.
     * @param DataboxDataboxBuilder $builder Instance of DataboxBuilder.
     */
    public function addData(\Databox\DataboxBuilder $builder)
    {
        foreach ($this->messages as $i => $message) {
            $builder->addKpi($this->key . "@message_" . $i, $message, ($this->date ? $this->date : NULL));
        }
        return $builder->getRawPayload();
    }
}
