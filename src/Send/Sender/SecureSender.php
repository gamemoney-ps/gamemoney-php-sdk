<?php

namespace Gamemoney\Send\Sender;

use Gamemoney\Exception\RequestException;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\SenderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class SecureSender
 * @package Gamemoney\Send\Sender
 */
final class SecureSender implements SenderInterface
{
    /** @var string */
    private $secureUrl;

    /** @var Client */
    private $client;

    /**
     * Sender constructor.
     * @param string $apiUrl
     * @param array $clientConfig
     */
    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
        $this->client = $this->getClient();
    }

    /**
     * @inheritdoc
     */
    public function send(RequestInterface $request)
    {
        try {
            $response = $this->client->post(
                $request->getAction(),
                [
                    'json' => json_encode($request->getData()),
                    'headers' => [
                        'Accept'     => 'application/json',
                    ],
                ]
            );
        } catch (GuzzleException $e) {
            throw new RequestException('Request Send Error', 0, $e);
        }

        $body = (string) $response->getBody();

        return json_decode($body, true);
    }

    /**
     * @return Client
     */
    private function getClient()
    {
        $defaultConfig = [
            'base_uri' => $this->secureUrl
        ];

        return new Client($defaultConfig);
    }
}
