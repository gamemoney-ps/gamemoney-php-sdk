<?php

namespace Gamemoney\CallbackHandler;

use Gamemoney\Config;
use Gamemoney\Exception\GameMoneyException;
use Gamemoney\Sign\SignatureVerifier;
use Gamemoney\Sign\SignatureVerifierInterface;
use Gamemoney\Sign\SignerResolver;
use Gamemoney\Sign\SignerResolverInterface;

/**
 * @package Gamemoney
 */
class BaseCallbackHandler
{
    protected SignatureVerifierInterface $signatureVerifier;

    protected SignerResolverInterface $signerResolver;

    public function __construct(Config $config)
    {
        $this->setSignatureVerifier(new SignatureVerifier($config->getCertificate()));
        $this->setSignerResolver(
            new SignerResolver($config->hmac(), $config->privateKey(), $config->privateKeyPassword()),
        );
    }

    public function setSignatureVerifier(SignatureVerifierInterface $signatureVerifier): self
    {
        $this->signatureVerifier = $signatureVerifier;
        return $this;
    }

    public function setSignerResolver(SignerResolverInterface $signerResolver): self
    {
        $this->signerResolver = $signerResolver;
        return $this;
    }

    /**
     * @param array<mixed> $data
     */
    public function check(array $data): bool
    {
        return $this->signatureVerifier->verify($data);
    }

    public function successAnswer(): string
    {
        $result = json_encode(['success' => 'true']);
        if ($result === false) {
            throw new GameMoneyException('Error within json_encode');
        }

        return $result;
    }

    public function errorAnswer(?string $error = null): string
    {
        $result = json_encode(
            array_merge(
                ['success' => 'error'],
                $error ? ['error' => $error] : [],
            ),
        );

        if ($result === false) {
            throw new GameMoneyException('Error within json_encode');
        }

        return $result;
    }
}
