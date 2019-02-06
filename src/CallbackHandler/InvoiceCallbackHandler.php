<?php
namespace Gamemoney\CallbackHandler;

use Gamemoney\Exception\ConfigException;
use Gamemoney\Sign\SignatureVerifier;
use Gamemoney\Sign\SignatureVerifierInterface;

/**
 * Class InvoiceCallbackHandler
 * See basic usage example in examples/invoice/callback.php
 * @package Gamemoney
 */
class InvoiceCallbackHandler
{
    /**
     * @var SignatureVerifierInterface
     */
    private $signatureVerifier;

    public function __construct($config)
    {
        if(empty($config['apiPublicKey'])) {
            throw new ConfigException('apiPublicKey is not set');
        }

        $this->setSignatureVerifier(new SignatureVerifier($config['apiPublicKey']));
    }

    /**
     * @param SignatureVerifierInterface $signatureVerifier
     * @return $this
     */
    public function setSignatureVerifier(SignatureVerifierInterface $signatureVerifier)
    {
        $this->signatureVerifier = $signatureVerifier;
        return $this;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function check(array $data)
    {
        return $this->signatureVerifier->verify($data);
    }

    /**
     * @return string
     */
    public function successAnswer()
    {
        return json_encode(['success' => 'true']);
    }

    /**
     * @param string|null $error
     * @return string
     */
    public function errorAnswer($error = null)
    {
        return json_encode(
            array_merge(
                ['success' => 'error'],
                $error ? ['error' => $error] : []
            )
        );
    }
}
