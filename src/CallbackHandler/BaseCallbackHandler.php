<?php
namespace Gamemoney\CallbackHandler;

use Gamemoney\Config;
use Gamemoney\Sign\SignatureVerifier;
use Gamemoney\Sign\SignatureVerifierInterface;

/**
 * Class BaseCallbackHandler
 * @package Gamemoney
 * @internal
 */
class BaseCallbackHandler
{
    /** @var SignatureVerifierInterface */
    protected $signatureVerifier;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->setSignatureVerifier(new SignatureVerifier($config->gmCertificate()));
    }

    /**
     * @param SignatureVerifierInterface $signatureVerifier
     * @return self
     */
    public function setSignatureVerifier(SignatureVerifierInterface $signatureVerifier)
    {
        $this->signatureVerifier = $signatureVerifier;

        return $this;
    }

    /**
     * @param array $data
     * @return bool
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
