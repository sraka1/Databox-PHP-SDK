<?php
namespace Databox;

use Guzzle\Common\Collection;
use Databox\DataboxClient;
use Guzzle\Service\Description\ServiceDescription;

class DataboxClientBuilder
{

    /**
     *
     * @var string
     */
    private $databoxBaseUrl = 'https://app.databox.com/';

    /**
     * API Key required for pushing the data to databox
     *
     * @var string
     */
    private $apiKey;

    private $userAgent = 'Databox-PHP-SDK/1.0';

    public function setDataboxBaseUrl($databoxBaseUrl)
    {
        $this->databoxBaseUrl = $databoxBaseUrl;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     *
     * @return DataboxClient
     */
    public function build()
    {
        if (! isset($this->apiKey)) {
            throw new \Exception("Databox API key not provided. Cannot build the Databox client without API Key provided.");
        }
        
        if (isset(config()->databox_base_url)) {
            $config['baseUrl'] = config()->databox_base_url;
        }
        
        // Default config options
        $default = array(
            'baseUrl' => $this->databoxBaseUrl,
            'apiKey' => $this->apiKey
        );
        
        // Merge in default settings and validate the config
        $config = Collection::fromConfig($config, $default, $required);
        
        $client = new DataboxClient($config->get('baseUrl'), $config);
        
        // Add authorization
        $client->addSubscriber(new Event\AuthListener($config->toArray()));
        
        // Set user-agent
        $client->setUserAgent($this->userAgent);
        
        // Improve the exceptions
        $client->addSubscriber(new Event\ExceptionListener());
        
        // Set service description
        $client->setDescription(ServiceDescription::factory(__DIR__ . DIRECTORY_SEPARATOR . 'config.php'));
        
        return $client;
    }
}