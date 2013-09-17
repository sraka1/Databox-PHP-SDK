<?php
namespace Databox\Event;

use Guzzle\Common\Event;
use Guzzle\Common\Collection;
use Guzzle\Http\Message\EntityEnclosingRequestInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Databox Auth
 * @package Databox
 */
class AuthListener implements EventSubscriberInterface
{
    /** @var Collection Configuration settings */
    protected $config;

    /**
     * Construct a new auth plugin
     *
     * @param array $config Configuration array containing these parameters:
     *     - string 'apiKey'              API key
     */
    public function __construct($config)
    {
        $this->config = Collection::fromConfig($config, array(), array(
            'apiKey'
        ));
    }

    public static function getSubscribedEvents()
    {
        return array(
            'request.before_send' => array('onRequestBeforeSend', -1000)
        );
    }

    /**
     * Request before-send event handler
     *
     * @param Event $event Event received
     */
    public function onRequestBeforeSend(Event $event)
    {
        $request = $event['request']; /* @var $request EntityEnclosingRequestInterface */

        if (!is_array($request->getHeader('Accept'))) {
            $request->setheader('Accept', 'application/json');
        }
        $header = $request->getHeader('Authorization');
        if (isset($this->config['apiKey']) && empty($header)) {
            $request->setAuth($this->config['apiKey'], 'DataboxPHPSDK');
        }

    }
}
