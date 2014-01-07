<?php
namespace Databox\Widget;

class Messages extends Base
{

    /**
     * Message array
     * @var array
     */
    protected $messages = [];

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
