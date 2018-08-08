<?php
namespace Gamemoney\Send;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Exception\RequestException;

final class Sender implements SenderInterface
{
    /** @var  string */
    private $apiUrl;
    /** @var Client */
    private $client;

    public function __construct($apiUrl, $clientConfig)
    {
        $this->apiUrl = $apiUrl;
        $this->client = $this->getClient($clientConfig);
    }

    /**
     * @param RequestInterface $request
     * @return array()
     * @throws RequestException
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

    private function getClient(array $clientConfig)
    {
        $defaultConfig = [
            'base_uri' => $this->apiUrl
        ];

        return new Client(array_merge($defaultConfig, $clientConfig));
    }
}