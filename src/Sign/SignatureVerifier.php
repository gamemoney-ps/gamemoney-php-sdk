<?php
namespace Gamemoney\Sign;

use Gamemoney\Exception\SignatureVerificationException;

/**
 * Class SignatureVerifier provides an ability to verify signature of data array
 *
 * Basic usage is the following:
 *
 * ```php
 * $data = [
 *     ...
 *     'signature' => ...
 * ];
 *  echo (new SignatureVerifier($publicKey))->verify($data);
 * ```
 */
final class SignatureVerifier implements SignatureVerifierInterface
{
    use ArrayToStringTrait;

    /** @var string */
    private $key;

    /**
     * SignatureVerifier constructor.
     * @param string $publicKey
     */
    public function __construct($publicKey)
    {
        $this->key = $publicKey;
    }

    /**
     * @inheritdoc
     */
    public function verify(array $data)
    {
        if (empty($data['signature'])) {
            return false;
        }

        $signature = base64_decode($data['signature']);
        unset($data['signature']);

        $text = $this->arrayToString($data);
        $pubKey = openssl_pkey_get_public($this->key);

        $signatureVerification = openssl_verify($text, $signature, $pubKey, 'sha256');

        if ($signatureVerification === -1) {
            throw new SignatureVerificationException(openssl_error_string());
        }

        return (bool) $signatureVerification;
    }
}
