<?php
namespace Gamemoney\Sign\Signer;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Sign\ArrayToStringTrait;
use Gamemoney\Sign\SignerInterface;

/**
 * Class HmacSigner provides an ability to get signature of data array using hmac key
 *
 *  * Basic usage is the following:
 *
 * ```php
 * echo (new HmacSigner($hmacKey))->getSignature($array);
 * ```
 * @package Gamemoney\Sign\Signer
 */
final class HmacSigner implements SignerInterface
{
    use ArrayToStringTrait;

    /** @var string */
    private $hmacKey;

    /**
     * HmacSigner constructor.
     * @param string $hmacKey
     */
    public function __construct($hmacKey)
    {
        $this->hmacKey = $hmacKey;
    }

    /**
     * Write signature
     * @param RequestInterface $request
     * @return RequestInterface $request
     */
    public function sign(RequestInterface $request)
    {
        $signature = $this->getSignature($request->getData());

        $request->setField('signature', $signature);

        return $request;
    }

    /**
     * @inheritdoc
     */
    public function getSignature(array $data)
    {
        return hash_hmac('sha256', $this->arrayToString($data), $this->hmacKey);
    }
}
