<?php
namespace Gamemoney\Sign\Signer;

use Gamemoney\Sign\ArrayToStringTrait;
use Gamemoney\Sign\SignerInterface;

final class HmacSigner implements SignerInterface
{
    use ArrayToStringTrait;

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