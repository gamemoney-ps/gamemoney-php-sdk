<?php
namespace Gamemoney\Send;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Exception\RequestException;

/**
 * Class Sender
 * @package Gamemoney\Send
 */
final class Sender implements SenderInterface
{
    /** @var string */
    private $apiUrl;

    /** @var Client */
    private $client;

    /**
     * Sender constructor.
     * @param string $apiUrl
     * @param array $clientConfig
     */
    public function __construct($apiUrl, array $clientConfig)
    {
        $this->apiUrl = $apiUrl;
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
                ['form_params' => $request->getData()]
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
            'base_uri' => $this->apiUrl
        ];

        return new Client(array_merge($defaultConfig, $clientConfig));
    }
}
