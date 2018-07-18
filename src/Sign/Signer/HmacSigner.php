<?php
namespace Gamemoney\Sign\Signer;

use Gamemoney\Sign\SignerInterface;
use Gamemoney\Exception\ConfigException;

final class HmacSigner extends BaseSigner implements SignerInterface
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