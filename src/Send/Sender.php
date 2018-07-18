<?php
namespace Gamemoney\Send;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Sign\SignerResolverInterface;
use Gamemoney\Exception\RequestException;

final class Sender implements SenderInterface
{
    /** @var  string */
    private $apiUrl;
    /** @var Client */
    private $client;

    /**
     * @var SignerResolverInterface
     */
    private $signerResolver;

    public function __construct($config, SignerResolverInterface $signerResolver)
    {
        $this->apiUrl = $config['apiUrl'];
        $this->signerResolver = $signerResolver;

        if (empty($config['clientConfig']) || is_array($config['clientConfig'])) {
            $config['clientConfig'] = [];
        }

        $this->client = $this->getClient($config['clientConfig']);
    }

    /**
     * @param RequestInterface $request
     * @return array()
     * @throws RequestException
     */
    public function send(RequestInterface $request)
    {
        $data = $request->getData();

        $signer = $this->signerResolver->resolve($request->getAction());
        $data['signature'] = $signer->getSignature($request->getData());

        try {
            $response = $this->client->post(
                $request->getAction(),
                ['form_params' => $data]
            );
        } catch (GuzzleException $e) {
            throw new RequestException($e->getMessage());
        }

        $body = (string) $response->getBody();
        return json_decode($body, true);
    }

    private function getClient(array $clientConfig = [])
    {
        $config = [
            'base_uri' => $this->apiUrl
        ];

        return new Client(array_merge($config, $clientConfig));
    }
}