<?php
namespace Gamemoney\Sign\Signer;

final class RsaSigner extends BaseSigner
{
    private $privateKey;
    private $passphrase;

    public function __construct($privateKey, $passphrase = '')
    {
        $this->privateKey = $privateKey;
        $this->passphrase = $passphrase;
    }

    /**
     * @inheritdoc
     */
    public function getSignature(array $data)
    {
        openssl_sign(
            $this->arrayToString($data),
            $signature,
            openssl_get_privatekey($this->privateKey, $this->passphrase),
            "sha256"
        );

        return base64_encode($signature);
    }
}