<?php

namespace Gamemoney\Send\Sender;

use Gamemoney\Exception\RequestException;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\SenderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class JsonSender
 * @package Gamemoney\Send\Sender
 */
final class JsonSender implements SenderInterface
{
    /** @var string */
    private $secureUrl;

    /** @var Client */
    private $client;

    /**
     * Sender constructor.
     * @param string $secureUrl
     * @param array $clientConfig
     */
    public function __construct($secureUrl, array $clientConfig)
    {
        $this->secureUrl = $secureUrl;
        $this->client = $this->getClient($clientConfig);
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
                    'json' => $request->getData(),
                    'headers' => [
                        'Accept' => 'application/json',
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
     * @param array $clientConfig
     * @return Client
     */
    private function getClient(array $clientConfig)
    {
        $defaultConfig = [
            'base_uri' => $this->secureUrl,
        ];

        return new Client(array_merge($defaultConfig, $clientConfig));
    }
}
