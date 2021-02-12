<?php

namespace Gamemoney\CallbackHandler;

use Gamemoney\Config;
use Gamemoney\Sign\SignatureVerifier;
use Gamemoney\Sign\SignatureVerifierInterface;
use Gamemoney\Sign\SignerResolver;
use Gamemoney\Sign\SignerResolverInterface;

/**
 * Class BaseCallbackHandler
 * @package Gamemoney
 */
class BaseCallbackHandler
{
    /** @var SignatureVerifierInterface */
    protected $signatureVerifier;

    /** @var SignerResolverInterface */
    protected $signerResolver;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->setSignatureVerifier(new SignatureVerifier($config->gmCertificate()));
        $this->setSignerResolver(
            new SignerResolver($config->hmac(), $config->privateKey(), $config->privateKeyPassword())
        );
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
     * @param SignerResolverInterface $signerResolver
     * @return self
     */
    public function setSignerResolver(SignerResolverInterface $signerResolver)
    {
        $this->signerResolver = $signerResolver;

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
