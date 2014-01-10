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

    private $userAgent = 'Databox-PHP-SDK/1.1';

    function __construct($baseUrl = 'https://app.databox.com/')
    {
        if (is_null($baseUrl)) {
            throw new \RuntimeException("Base URL has to be provided.");
        }
        parent::__construct($baseUrl);
        
        // Set user-agent
        $this->setUserAgent($this->userAgent);
        
        // Improve the exceptions
        $this->addSubscriber(new Event\ExceptionListener());
        
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
        $appId = $dataProvider->getAppId();
        if (! isset($appId) || $appId == '') {
            throw new \RuntimeException("API KEY not provided for connection.");
        }
        $appId = $dataProvider->getAppId();
        
        /* if push URL is still not set, then this is an error */
        if (! isset($appId)) {
            throw new \Exception("Push URL not provided.");
        }
        
        $config = array(
            'apiKey' => $dataProvider->getApiKey()
        );
        
        $this->addSubscriber(new Event\AuthListener($config));
        
        $payload = $dataProvider->getPayload();
        /* if all data is provided then push the data */
        return $this->setPushData([
            'uniqueUrl' => $appId,
            'payload' => $payload
        ]);
    }
}
