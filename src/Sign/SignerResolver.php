<?php

namespace Gamemoney\Sign;

use Gamemoney\Exception\ConfigException;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Sign\Signer\EmptySigner;
use Gamemoney\Sign\Signer\RsaSigner;
use Gamemoney\Sign\Signer\HmacSigner;

/**
 * @package Gamemoney\Sign
 */
class SignerResolver implements SignerResolverInterface
{
    private string $hmacKey;

    private ?string $privateKey;

    private ?string $passphrase;

    public function __construct(string $hmacKey, ?string $privateKey, ?string $passphrase)
    {
        $this->hmacKey = $hmacKey;
        $this->privateKey = $privateKey;
        $this->passphrase = $passphrase;
    }

    public function resolve(?string $action = null): SignerInterface
    {
        if (preg_match(RequestInterface::STORE_ONLY_CARD_DATA_REGEX, (string) $action)) {
            return new EmptySigner();
        }

        if (in_array($action, [RequestInterface::CHECKOUT_CREATE_ACTION, RequestInterface::CHECKOUT_CHECK_ACTION])) {
            if (is_null($this->privateKey)) {
                throw new ConfigException('Private key is not set');
            }

            return new RsaSigner($this->privateKey, $this->passphrase);
        }

        return new HmacSigner($this->hmacKey);
    }
}
