<?php
namespace Databox;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Databox\Client\IClient;

/**
 * Databox client
 *
 * @method \Guzzle\Service\Resource\Model setPushData(array $args = array())
 * @method \Guzzle\Service\Resource\Model getPushDataLog(array $args = array())
 */
class DataboxClient extends Client implements IClient
{

    /**
     *
     * @var string
     */
    private $pushUrl;
    
    /*
     * (non-PHPdoc) @see \Databox\Client\IClient::pushData()
     */
    public function pushData(array $payload, $pushUrl = null)
    {
        if (! isset($pushUrl)) {
            $pushUrl = $this->pushUrl;
        }
        if (! isset($pushUrl)) {
            throw new \Exception("push URL not provided.");
        }
        /* if all data is provided then push the data */
        $this->setPushData([
            'uniqueUrl' => $this->pushUrl,
            'payload' => $payload
        ]);
    }
    
    /*
     * (non-PHPdoc) @see \Databox\Client\IClient::setPushUrl()
     */
    public function setPushUrl($pushUrl)
    {
        $this->pushUrl = $pushUrl;
    }
}
