<?php
namespace Gamemoney\Sign\Signer;

final class HmacSigner extends BaseSigner
{
    private $hmacKey;

    public function __construct($hmacKey)
    {
        $this->hmacKey = $hmacKey;
    }

    /**
     * @inheritdoc
     */
    public function getSignature(array $data)
    {
        return hash_hmac("sha256", $this->arrayToString($data), $this->hmacKey);
    }
}