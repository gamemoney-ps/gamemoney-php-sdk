<?php

namespace Gamemoney\Send;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\Sender\JsonSender;
use Gamemoney\Send\Sender\Sender;

/**
 * Class SenderResolver
 * @package Gamemoney\Send
 */
class SenderResolver implements SenderResolverInterface
{
    /** @var string */
    private $apiUrl;

    /** @var string */
    private $secureUrl;

    /** @var array */
    private $clientConfig;

    public function __construct($apiUrl, $secureUrl, $clientConfig)
    {
        $this->apiUrl = $apiUrl;
        $this->secureUrl = $secureUrl;
        $this->clientConfig = $clientConfig;
    }

    /**
     * @inheritdocs
     */
    public function resolve($action)
    {
        if (preg_match(RequestInterface::STORE_ONLY_CARD_DATA_REGEX, $action)) {
            return new JsonSender($this->secureUrl, $this->clientConfig);
        }

        return new Sender($this->apiUrl, $this->clientConfig);
    }
}
