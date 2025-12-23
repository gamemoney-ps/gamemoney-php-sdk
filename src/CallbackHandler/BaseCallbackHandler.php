<?php

namespace Gamemoney\CallbackHandler;

use Gamemoney\Config;
use Gamemoney\Exception\GameMoneyException;
use Gamemoney\Sign\SignatureVerifier;
use Gamemoney\Sign\SignatureVerifierInterface;
use Gamemoney\Sign\SignerResolver;
use Gamemoney\Sign\SignerResolverInterface;

class BaseCallbackHandler
{
    protected SignatureVerifierInterface $signatureVerifier;

    protected SignerResolverInterface $signerResolver;

    public function __construct(Config $config)
    {
        $this->setSignatureVerifier(new SignatureVerifier($config->getCertificate()));
        $this->setSignerResolver(
            new SignerResolver($config->getHmac(), $config->getPrivateKey(), $config->getPrivateKeyPassword()),
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

    public function getSuccessAnswer(): string
    {
        $result = json_encode(['success' => 'true']);
        if (false === $result) {
            throw new GameMoneyException('Error within json_encode');
        }

        return $result;
    }

    public function getErrorAnswer(?string $error = null): string
    {
        $result = json_encode(
            array_merge(
                ['success' => 'error'],
                $error ? ['error' => $error] : [],
            ),
        );

        if (false === $result) {
            throw new GameMoneyException('Error within json_encode');
        }

        return $result;
    }
}
