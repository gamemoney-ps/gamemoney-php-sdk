<?php
namespace Gamemoney;

use Gamemoney\Exception\ConfigException;
use Gamemoney\Sign\SignatureVerifier;
use Gamemoney\Sign\SignatureVerifierInterface;

class CallbackHandler
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
}