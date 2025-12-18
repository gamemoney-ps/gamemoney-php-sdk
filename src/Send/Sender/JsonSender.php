<?php

namespace Gamemoney\Send\Sender;

use Gamemoney\Exception\RequestException;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\SenderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * @package Gamemoney\Send\Sender
 */
final class JsonSender implements SenderInterface
{
    private string $secureUrl;

    private Client $client;

    /**
     * @param array<mixed> $clientConfig
     */
    public function __construct(string $secureUrl, array $clientConfig)
    {
        $this->secureUrl = $secureUrl;
        $this->client = $this->getClient($clientConfig);
    }

    /**
     * @inheritDoc
     */
    public function send(RequestInterface $request): array
    {
        try {
            $response = $this->client->post(
                $request->getAction(),
                [
                    'json' => $request->getData(),
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                ],
            );
        } catch (GuzzleException $e) {
            throw new RequestException('Request Send Error', 0, $e);
        }

        $body = (string) $response->getBody();

        return json_decode($body, true);
    }

    /**
     * @param array<mixed> $clientConfig
     */
    private function getClient(array $clientConfig): Client
    {
        $defaultConfig = [
            'base_uri' => $this->secureUrl,
        ];

        return new Client(array_merge($defaultConfig, $clientConfig));
    }
}
