<?php
namespace Gamemoney\Sign;

final class SignatureVerifier implements SignatureVerifierInterface
{
    use ArrayToStringTrait;

    private $key;

    public function __construct($publicKey)
    {
        $this->key = $publicKey;
    }

    public function verify(array $data)
    {
        if(empty($data['signature'])) {
            return false;
        }

        $signature = base64_decode($data['signature']);
        unset($data['signature']);

        $text = $this->arrayToString($data);
        $pubKey = openssl_pkey_get_public($this->key);

        return openssl_verify($text, $signature, $pubKey, "sha256");
    }
}