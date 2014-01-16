<?php
namespace Databox\Widget;

use \Databox\KPI as KPI;

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
     * Set entire messages array
     * @param string $message The messages to be set.
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
     * Returns a response array.
     */
    public function getData()
    {
        $response = [];
        foreach ($this->messages as $i => $message) {
            $response[] = new KPI($this->key, $this->messages, ($this->date ? $this->date : NULL));
        }
        return $response;
    }
}
