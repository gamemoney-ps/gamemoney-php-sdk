<?php
namespace Gamemoney\Sign\Signer;

use Gamemoney\Exception\ConfigException;
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

    /**
     * @var resource|string
     */
    private $privateKey;

    /**
     * @var string 
     */
    private $passphrase;

    public function __construct($privateKey, $passphrase = '')
    {
        if (empty($privateKey)) {
            throw new ConfigException('privateKey is not set in config');
        }

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