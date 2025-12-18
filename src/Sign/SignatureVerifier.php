<?php

namespace Gamemoney\Sign;

use Gamemoney\Exception\GameMoneyException;
use Gamemoney\Exception\SignatureVerificationException;

/**
 * Class SignatureVerifier provides an ability to verify signature of data array
 *
 * Basic usage is the following:
 *
 * ```php
 * $data = [
 *     ...
 *     'signature' => ...
 * ];
 *  echo (new SignatureVerifier($publicKey))->verify($data);
 * ```
 */
final class SignatureVerifier implements SignatureVerifierInterface
{
    use ArrayToStringTrait;

    private string $key;

    public function __construct(string $publicKey)
    {
        $this->key = $publicKey;
    }

    /**
     * @inheritDoc
     */
    public function verify(array $data): bool
    {
        if (empty($data['signature'])) {
            return false;
        }

        $signature = base64_decode($data['signature']);
        unset($data['signature']);

        $text = $this->arrayToString($data);
        $pubKey = openssl_pkey_get_public($this->key);
        if ($pubKey === false) {
            throw new GameMoneyException((string) openssl_error_string());
        }

        $signatureVerification = openssl_verify($text, $signature, $pubKey, 'sha256');

        if ($signatureVerification === -1) {
            throw new SignatureVerificationException((string) openssl_error_string());
        }

        return (bool) $signatureVerification;
    }
}
