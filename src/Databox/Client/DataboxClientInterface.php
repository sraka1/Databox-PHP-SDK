<?php
namespace Databox\Client;

/**
 * This interface should go in Databox-PHP-SDK.
 * DataboxClient should implement this interface (setPushData() should be refactored to pushData).
 *
 * @author Uroš Majerič
 *        
 */
interface DataboxClientInterface
{

    /**
     *
     * @param array $payload Data to be pushed
     * @param string $pushUrl Should be provided if setPushUrl was not called.
     *
     * @return array The server response.
     */
    public function pushData($payload, $pushUrl = null);

    /**
     *
     * @param string $pushUrl            
     */
    public function setPushUrl($pushUrl);
}