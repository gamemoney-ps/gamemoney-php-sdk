<?php
namespace Gamemoney\Sign\Signer;

use Gamemoney\Sign\SignerInterface;
use Gamemoney\Exception\ConfigException;

final class RsaSigner extends BaseSigner implements SignerInterface
{
    private $rsaKey;
    private $passphrase;

    public function __construct($rsaKey, $passphrase = '')
    {
        if (empty($rsaKey)) {
            throw new ConfigException('rsaKey is not set');
        }

        $this->rsaKey = $rsaKey;
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
            openssl_pkey_get_private($this->rsaKey, $this->passphrase),
            "sha256"
        );

        return base64_encode($signature);
    }
}