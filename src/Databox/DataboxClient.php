<?php
namespace Databox;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

/**
 * Databox client
 *
 * @method \Guzzle\Service\Resource\Model setPushData(array $args = array())
 * @method \Guzzle\Service\Resource\Model getPushDataLog(array $args = array())
 */
class DataboxClient extends Client
{
    public static function factory($config = array())
    {
        // Default config options
        $default = array('baseUrl' => 'https://app.databox.com/');

        // The following values are required when creating the client
        $required = array(
            'apiKey'
        );

        // Merge in default settings and validate the config
        $config = Collection::fromConfig($config, $default, $required);

        // Create a new client
        $client = new self($config->get('baseUrl'), $config);

        // Add authorization
        $client->addSubscriber(new Event\AuthListener($config->toArray()));

        //Set user-agent
        $client->setUserAgent('Databox-PHP-SDK/1.0');

        // Improve the exceptions
        $client->addSubscriber(new Event\ExceptionListener());

        // Set service description
        $client->setDescription(ServiceDescription::factory(__DIR__.DIRECTORY_SEPARATOR.'config.php'));

        return $client;
    }

}
