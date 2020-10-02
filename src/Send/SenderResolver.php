<?php

namespace Gamemoney\Send;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\Sender\SecureSender;
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
        if ($action == RequestInterface::CARD_TRANSFER) {
            return new SecureSender($this->secureUrl);
        }

        return new Sender($this->apiUrl, $this->clientConfig);
    }
}
