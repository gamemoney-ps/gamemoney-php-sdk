<?php
namespace Gamemoney\Sign\Signer;

final class RsaSigner extends BaseSigner
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