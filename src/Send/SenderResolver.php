<?php

namespace Gamemoney\Send;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\Sender\JsonSender;
use Gamemoney\Send\Sender\Sender;

/**
 * @package Gamemoney\Send
 */
class SenderResolver implements SenderResolverInterface
{
    private string $apiUrl;

    private string $secureUrl;

    /** @var array<mixed> */
    private array $clientConfig;

    /**
     * @param array<mixed> $clientConfig
     */
    public function __construct(string $apiUrl, string $secureUrl, array $clientConfig)
    {
        $this->apiUrl = $apiUrl;
        $this->secureUrl = $secureUrl;
        $this->clientConfig = $clientConfig;
    }

    public function resolve(string $action): SenderInterface
    {
        if (preg_match(RequestInterface::STORE_ONLY_CARD_DATA_REGEX, $action)) {
            return new JsonSender($this->secureUrl, $this->clientConfig);
        }

        return new Sender($this->apiUrl, $this->clientConfig);
    }
}
