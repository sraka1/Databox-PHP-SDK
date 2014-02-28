<?php
namespace Databox;

use Guzzle\Service\Client;
use Databox\Client\DataboxClientInterface;
use Guzzle\Service\Description\ServiceDescription;

/**
 * Databox client
 *
 * @method \Guzzle\Service\Resource\Model setPushData(array $args = array())
 * @method \Guzzle\Service\Resource\Model getPushDataLog(array $args = array())
 */
class DataboxClient extends Client implements DataboxClientInterface
{

    protected $userAgent = 'Databox-PHP-SDK/1.2';

    private $authListener;

    private $uniqueUrl;

    public function __construct($baseUrl = 'https://app.databox.com/')
    {
        if (is_null($baseUrl)) {
            throw new \RuntimeException("Base URL has to be provided.");
        }
        parent::__construct($baseUrl);
        
        // Set user-agent
        $this->setUserAgent($this->userAgent);
        
        // Improve the exceptions
        $this->addSubscriber(new Event\ExceptionListener());
        $this->authListener = new Event\AuthListener('');
        $this->addSubscriber($this->authListener);
        
        // Set service description
        $this->setDescription(ServiceDescription::factory(__DIR__ . DIRECTORY_SEPARATOR . 'config.php'));
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Databox\Client\DataboxClientInterface::pushData()
     */
    public function pushData(DataboxBuilder $dataProvider)
    {   
        if (is_null($this->uniqueUrl)) {
            throw new \Exception("Push URL not provided.");
        }

        if (is_null($this->authListener->getApiKey())) {
            throw new \Exception("Api key not set.");
        }
        
        $payload = $dataProvider->getPayload();
        /* if all data is provided then push the data */
        return $this->setPushData([
            'uniqueUrl' => $this->uniqueUrl,
            'payload' => $payload
        ]);
    }

    /**
     * Sets the API key
     * @param string $apiKey The API key to be set.
     */
    public function setApiKey($apiKey)
    {
        $this->authListener->setApiKey($apiKey);
    }

    /**
     * Sets unique URL for push
     * @param string $uniqueUrl Sets the unique URL.
     */
    public function setUniqueUrl($uniqueUrl)
    {
        $this->uniqueUrl = $uniqueUrl;
    }

    /**
     * Returns the push log
     * @return array Server response.
     */
    public function getPushLog()
    {
        if (is_null($this->uniqueUrl)) {
            throw new \Exception("Push URL not provided.");
        }

        if (is_null($this->authListener->getApiKey())) {
            throw new \Exception("Api key not set.");
        }

        return $this->getPushDataLog([
            'uniqueUrl' => $this->uniqueUrl
        ]);
    }
}
