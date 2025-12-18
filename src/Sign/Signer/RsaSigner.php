<?php

namespace Gamemoney\Sign\Signer;

use Gamemoney\Exception\PrivateKeyException;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Sign\ArrayToStringTrait;
use Gamemoney\Sign\SignerInterface;

/**
 * Class RsaSigner provides an ability to get signature of data array using RSA private key
 *
 *  * Basic usage is the following:
 *
 * ```php
 * echo (new RsaSigner($privateKey))->getSignature($array);
 * ```
 * @package Gamemoney\Sign\Signer
 */
final class RsaSigner implements SignerInterface
{
    use ArrayToStringTrait;

    private string $privateKey;

    private ?string $passPhrase;

    public function __construct(string $privateKey, ?string $passPhrase)
    {
        $this->privateKey = $privateKey;
        $this->passPhrase = $passPhrase;
    }

    /**
     * Write signature
     * @throws PrivateKeyException
     */
    public function sign(RequestInterface $request): RequestInterface
    {
        $signature = $this->getSignature($request->getData());

        $request->setField('signature', $signature);

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function getSignature(array $data): string
    {
        $privateKey = openssl_pkey_get_private($this->privateKey, $this->passPhrase);

        if ($privateKey === false) {
            throw new PrivateKeyException((string) openssl_error_string());
        }

        openssl_sign($this->arrayToString($data), $signature, $privateKey, 'sha256');

        return base64_encode($signature);
    }
}
