<?php
namespace Databox;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Databox\Client\DataboxClientInterface;

/**
 * Databox client
 *
 * @method \Guzzle\Service\Resource\Model setPushData(array $args = array())
 * @method \Guzzle\Service\Resource\Model getPushDataLog(array $args = array())
 */
class DataboxClient extends Client implements DataboxClientInterface
{

    /**
     *
     * @var string
     */
    private $pushUrl;
    
    /*
     * (non-PHPdoc) @see \Databox\Client\DataboxClientInterface::pushData()
     */
    public function pushData($payload, $pushUrl = null)
    {
        if (! isset($pushUrl) || $pushUrl == '') {
            $pushUrl = $this->pushUrl;
        }
        
        /* if push URL is still not set, then this is an error */
        if (! isset($pushUrl)) {
            throw new \Exception("Push URL not provided.");
        }
        /* if all data is provided then push the data */
        return $this->setPushData([
            'uniqueUrl' => $pushUrl,
            'payload' => $payload
        ]);
    }
    
    /*
     * (non-PHPdoc) @see \Databox\Client\DataboxClientInterface::setPushUrl()
     */
    public function setPushUrl($pushUrl)
    {
        $this->pushUrl = $pushUrl;
    }
}
