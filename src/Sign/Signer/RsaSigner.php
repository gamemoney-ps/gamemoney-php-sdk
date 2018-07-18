<?php
namespace Gamemoney\Sign\Signer;

use Gamemoney\Sign\SignerInterface;

final class RsaSigner extends BaseSigner implements SignerInterface
{
    private $privateKey;

    public function __construct($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @inheritdoc
     */
    public function getSignature(array $data)
    {
        openssl_sign(
            $this->arrayToString($data),
            $signature,
            $this->privateKey,
            "sha256"
        );

        return base64_encode($signature);
    }
}