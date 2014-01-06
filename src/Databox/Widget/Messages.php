<?php
namespace Databox\Widget;

class Messages
{

    /**
     * Class for Table data
     */
    protected $key;

    /**
     * Message array
     * @var array
     */
    protected $messages;


    public function __construct($key)
    {
        $this->messages   = [];
        $this->key        = $key;
    }

    public function addMessage($message)
    {
        $this->messages[] = $message;
    }

    public function addData(\Databox\DataboxBuilder $builder)
    {
        foreach ($this->messages as $i => $message) {
            $builder->addKpi($this->key . "@message_" . $i, $message);
        }
        return $builder->getRawPayload();
    }
}
