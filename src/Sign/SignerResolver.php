<?php

namespace Gamemoney\Sign;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Sign\Signer\EmptySigner;
use Gamemoney\Sign\Signer\RsaSigner;
use Gamemoney\Sign\Signer\HmacSigner;

/**
 * Class SignerResolver
 * @package Gamemoney\Sign
 */
class SignerResolver implements SignerResolverInterface
{
    /** @var string */
    private $hmacKey;

    /** @var string|null */
    private $privateKey;

    /** @var string */
    private $passphrase;

    /**
     * SignerResolver constructor.
     * @param string $hmacKey
     * @param string $privateKey
     * @param string $passphrase
     */
    public function __construct($hmacKey, $privateKey, $passphrase)
    {
        $this->hmacKey = $hmacKey;
        $this->privateKey = $privateKey;
        $this->passphrase = $passphrase;
    }

    /**
     * @inheritdoc
     */
    public function resolve($action = null)
    {
        if (preg_match(RequestInterface::STORE_ONLY_CARD_DATA_REGEX, (string) $action)) {
            return new EmptySigner();
        }

        if (in_array($action, [RequestInterface::CHECKOUT_CREATE_ACTION, RequestInterface::CHECKOUT_CHECK_ACTION])) {
            return new RsaSigner($this->privateKey, $this->passphrase);
        }

        return new HmacSigner($this->hmacKey);
    }
}
