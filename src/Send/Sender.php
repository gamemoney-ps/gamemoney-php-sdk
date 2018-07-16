<?php
namespace Gamemoney\Send;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Sign\SignerResolverInterface;
use Gamemoney\Exception\RequestException;

final class Sender implements SenderInterface
{
    private $apiUrl;

    /**
     * @var SignerResolverInterface
     */
    private $signerResolver;

    public function __construct($config, SignerResolverInterface $signerResolver)
    {
        $this->projectId = $config['id'];
        $this->apiUrl = $config['apiUrl'];
        $this->signerResolver = $signerResolver;

        if (empty($config['clientConfig']) || is_array($config['clientConfig'])) {
            $config['clientConfig'] = [];
        }

        $this->client = $this->getClient($config['clientConfig']);
    }

    public function send(RequestInterface $request)
    {
        $data = $request->getData();
        $data['project'] = $this->projectId;

        if (empty($data['rand'])) {
            $data['rand'] = $this->getRandString();
        }

        $signer = $this->signerResolver->resolve($request->getAction());
        $data['signature'] = $signer->getSignature($request->getData());

        try {
            $response = $this->client->post(
                $request->getAction(),
                ['form_params' => $data]
            );
        } catch (\GuzzleException $e) {
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