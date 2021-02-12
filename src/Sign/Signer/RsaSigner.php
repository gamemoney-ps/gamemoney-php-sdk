<?php

namespace Gamemoney\Sign\Signer;

use Gamemoney\Exception\ConfigException;
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

    /** @var string */
    private $privateKey;

    /** @var string */
    private $passphrase;

    /**
     * RsaSigner constructor.
     * @param string $privateKey
     * @param string $passphrase
     * @throws ConfigException
     */
    public function __construct($privateKey, $passphrase = '')
    {
        if (empty($privateKey)) {
            throw new ConfigException('privateKey is not set in config');
        }

        $this->privateKey = $privateKey;
        $this->passphrase = $passphrase;
    }

    /**
     * Write signature
     * @param RequestInterface $request
     * @return RequestInterface $request
     * @throws PrivateKeyException
     */
    public function sign(RequestInterface $request)
    {
        $signature = $this->getSignature($request->getData());

        $request->setField('signature', $signature);

        return $request;
    }

    /**
     * @inheritdoc
     */
    public function getSignature(array $data)
    {
        $privateKey = openssl_pkey_get_private($this->privateKey, $this->passphrase);

        if ($privateKey === false) {
            throw new PrivateKeyException(openssl_error_string());
        }

        openssl_sign($this->arrayToString($data), $signature, $privateKey, 'sha256');

        return base64_encode($signature);
    }
}
