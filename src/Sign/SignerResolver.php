<?php

namespace Gamemoney\Sign;

use Gamemoney\Exception\ConfigException;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Sign\Signer\HmacSigner;
use Gamemoney\Sign\Signer\RsaSigner;

class SignerResolver implements SignerResolverInterface
{
    private string $hmacKey;

    private ?string $privateKey;

    private ?string $passPhrase;

    public function __construct(string $hmacKey, ?string $privateKey, ?string $passPhrase)
    {
        $this->hmacKey = $hmacKey;
        $this->privateKey = $privateKey;
        $this->passPhrase = $passPhrase;
    }

    public function resolve(?string $action = null): SignerInterface
    {
        if (in_array($action, [RequestInterface::CHECKOUT_CREATE_ACTION, RequestInterface::CHECKOUT_CHECK_ACTION])) {
            if (is_null($this->privateKey)) {
                throw new ConfigException('Private key is not set');
            }

            return new RsaSigner($this->privateKey, $this->passPhrase);
        }

        return new HmacSigner($this->hmacKey);
    }
}
