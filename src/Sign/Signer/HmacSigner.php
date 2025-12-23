<?php

namespace Gamemoney\Sign\Signer;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Sign\ArrayToStringTrait;
use Gamemoney\Sign\SignerInterface;

/**
 * Class HmacSigner provides an ability to get signature of data array using hmac key.
 *
 *  * Basic usage is the following:
 *
 * ```php
 * echo (new HmacSigner($hmacKey))->getSignature($array);
 * ```
 */
final class HmacSigner implements SignerInterface
{
    use ArrayToStringTrait;

    private string $hmacKey;

    public function __construct(string $hmacKey)
    {
        $this->hmacKey = $hmacKey;
    }

    public function sign(RequestInterface $request): RequestInterface
    {
        $signature = $this->getSignature($request->getData());

        $request->setField('signature', $signature);

        return $request;
    }

    public function getSignature(array $data): string
    {
        return hash_hmac('sha256', $this->arrayToString($data), $this->hmacKey);
    }
}
