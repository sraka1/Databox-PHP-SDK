<?php
namespace Databox\Client;

/**
 * This interface should go in Databox-PHP-SDK.
 * DataboxClient should implement this interface (setPushData() should be refactored to pushData).
 *
 * @author uros
 *        
 */
interface IClient
{

    /**
     *
     * @param array $payload
     *            - data to be pushed
     * @param string $pushUrl
     *            - should be provided if setPushUrl was not called.
     */
    public function pushData($payload, $pushUrl = null);

    /**
     *
     * @param string $pushUrl            
     */
    public function setPushUrl($pushUrl);
}