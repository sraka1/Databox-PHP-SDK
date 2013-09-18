<?php
/**
 * Databox Push API description.
 * See developers.databox.com for more info
 * Provided as a PHP array to allow PHP APC caching
 */
return array(
    'name' => 'Databox',
    'apiVersion' => '1',
    'description' => 'Databox custom application data push client',
    'operations' => array(
        'SetPushData' => array(
            'httpMethod' => 'POST',
            'uri' => 'push/custom/{uniqueUrl}',
            'summary' => 'Push data to your custom app',
            'responseClass' => 'SetPushDataOutput',
            'parameters' => array(
                'uniqueUrl' => array(
                    'description' => 'The unique URL of your app',
                    'type' => 'string',
                    'location' => 'uri',
                    'required' => true
                ),
                'payload' => array(
                    'description' => 'The actual data payload',
                    'type' => 'string',
                    'location' => 'body',
                    'required' => true
                ),
            )
        ),
        'GetPushDataLog' => array(
            'httpMethod' => 'GET',
            'uri' => 'push/custom/{uniqueUrl}/logs',
            'summary' => 'Get a log of all pushed data to your app',
            'responseClass' => 'GetPushDataLogOutput',
            'parameters' => array(
                'uniqueUrl' => array(
                    'description' => 'The unique URL of your app',
                    'type' => 'string',
                    'location' => 'uri',
                    'required' => true
                )
            )
        )
    ),
    'models' => array(
        'SetPushDataOutput' => array(
            'type' => 'object',
            'additionalProperties' => array(
                'location' => 'json'
            )
        ),
        'GetPushDataLogOutput' => array(
            'type' => 'object',
            'additionalProperties' => array(
                'location' => 'json'
            )
        ),
    )
);
