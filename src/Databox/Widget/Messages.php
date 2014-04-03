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
     * Icon array
     * @var array
     */
    protected $icons = [];

    /**
     * Add a new message to the Messages widget
     * @param string $message The message to be added.
     */
    public function addMessage($message, $icon)
    {
        $this->messages[] = $message;
        $this->icons[]    = $icon;
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
        $response[] = new KPI($this->key . "@labels", $this->messages, ($this->date ? $this->date : NULL));
        $response[] = new KPI($this->key . "@icons", $this->icons, ($this->date ? $this->date : NULL));
        return $response;
    }
}
