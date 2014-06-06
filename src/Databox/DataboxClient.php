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
    const DATABOX_API_BASEURL = 'https://api.databox.com';

    protected $userAgent = 'Databox-PHP-SDK/1.2';

    private $authListener;

    private $uniqueUrl;

    private $userAccessToken;

    public function __construct($accessToken, $baseUrl = self::DATABOX_API_BASEURL)
    {
        if (is_null($accessToken)) {
            throw new \RuntimeException('Access token is required.');
        }
        $this->userAccessToken = $accessToken;

        parent::__construct($baseUrl);

        // Set user-agent
        $this->setUserAgent($this->userAgent);

        // Improve the exceptions
        $this->addSubscriber(new Event\ExceptionListener());
        $this->authListener = new Event\AuthListener('');
        $this->addSubscriber($this->authListener);

        // Set service description
        $this->setDescription(ServiceDescription::factory(__DIR__ . DIRECTORY_SEPARATOR . 'config.php'));

        // TODO: Add setAccessToken function to AuthListener class
        $this->authListener->setApiKey($this->userAccessToken);
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

        // Max data size is 1MB. Split it.
        if ($dataProvider->isPayloadTooBig()) { // Actually 1048576, but let's be sure
            $payloads = $dataProvider->getSplittedPayloads();
            $responses = [];
            foreach ($payloads as $payload) {
                $responses[] = $this->setPushData([
                    'uniqueUrl' => $this->uniqueUrl,
                    'payload' => $payload
                ]);
            }
            return $responses;
        } else {
            $payload = $dataProvider->getPayload();
            /* if all data is provided then push the data */
            return $this->setPushData([
                'uniqueUrl' => $this->uniqueUrl,
                'payload' => $payload
            ]);
        }

    }

    /**
     * OBSOLETE - will be removed in next release
     *
     * Sets the API key
     * @param string $apiKey The API key to be set.
     */
    public function setApiKey($apiKey)
    {
        $this->authListener->setApiKey($apiKey);
    }

    /**
     * OBSOLETE - will be removed in next release
     *
     * Sets unique URL for push
     * @param string $uniqueUrl Sets the unique URL.
     */
    public function setUniqueUrl($uniqueUrl)
    {
        $this->uniqueUrl = $uniqueUrl;
    }

    /**
     * Set source token
     *
     * @param string $sourceToken Token of the custom source
     */
    public function setSourceToken($sourceToken)
    {
        $this->uniqueUrl = $sourceToken;
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
