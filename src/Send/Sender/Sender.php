<?php

namespace Gamemoney\Send\Sender;

use Gamemoney\Send\SenderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Exception\RequestException;

/**
 * @package Gamemoney\Send\Sender
 */
final class Sender implements SenderInterface
{
    private string $apiUrl;

    private Client $client;

    /**
     * @param array<mixed> $clientConfig
     */
    public function __construct(string $apiUrl, array $clientConfig)
    {
        $this->apiUrl = $apiUrl;
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
                ['form_params' => $request->getData()],
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
            'base_uri' => $this->apiUrl,
        ];

        return new Client(array_merge($defaultConfig, $clientConfig));
    }
}
