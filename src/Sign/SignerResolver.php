<?php
namespace Gamemoney\Sign;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Sign\Signer\EmptySigner;
use Gamemoney\Sign\Signer\RsaSigner;
use Gamemoney\Sign\Signer\HmacSigner;

/**
 * Class SignerResolver
 * @package Gamemoney\Sign
 */
class SignerResolver implements SignerResolverInterface
{
    /** @var string */
    private $hmacKey;

    /** @var string|null */
    private $privateKey;

    /** @var string */
    private $passphrase;

    /**
     * SignerResolver constructor.
     * @param string $hmacKey
     * @param string $privateKey
     * @param string $passphrase
     */
    public function __construct($hmacKey, $privateKey, $passphrase)
    {
        $this->hmacKey = $hmacKey;
        $this->privateKey = $privateKey;
        $this->passphrase = $passphrase;
    }

    /**
     * @inheritdoc
     */
    public function resolve($action)
    {
        if (preg_match(RequestInterface::STORE_ONLY_CARD_DATA_REGEX, $action)) {
            return new EmptySigner();
        }

        if ($action === RequestInterface::CHECKOUT_CREATE_ACTION) {
            return new RsaSigner($this->privateKey, $this->passphrase);
        }

        return new HmacSigner($this->hmacKey);
    }
}
