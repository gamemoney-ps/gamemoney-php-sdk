<?php

namespace Gamemoney;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Exception\ConfigException;
use Gamemoney\Send\SenderResolver;
use Gamemoney\Send\SenderResolverInterface;
use Gamemoney\Sign\SignatureVerifier;
use Gamemoney\Sign\SignerResolverInterface;
use Gamemoney\Validation\Request\RequestValidator;
use Gamemoney\Validation\Request\RequestValidatorInterface;
use Gamemoney\Validation\Request\RulesResolver;
use Gamemoney\Validation\Request\RulesResolverInterface;
use Gamemoney\Sign\SignerResolver;
use Gamemoney\Validation\Response\ResponseValidatorResolver;
use Gamemoney\Validation\Response\ResponseValidatorResolverInterface;

/**
 * See using examples in examples folder
 * @package Gamemoney
 */
class Gateway
{
    private Config $config;

    private RequestValidatorInterface $requestValidator;

    private RulesResolverInterface $rulesResolver;

    private SignerResolverInterface $signerResolver;

    private SenderResolverInterface $senderResolver;

    private ResponseValidatorResolverInterface $responseValidatorResolver;

    /**
     * @param array<mixed> $clientConfig
     * @throws ConfigException
     */
    public function __construct(Config $gatewayConfig, array $clientConfig = [])
    {
        $this->config = $gatewayConfig;

        $signerResolver = new SignerResolver(
            $this->config->hmac(),
            $this->config->privateKey(),
            $this->config->privateKeyPassword(),
        );

        $senderResolver = new SenderResolver(
            $this->config->apiUrl(),
            $this->config->secureUrl(),
            $clientConfig,
        );

        $responseValidatorResolver = new ResponseValidatorResolver(
            new SignatureVerifier($this->config->getCertificate()),
        );

        $this
            ->setRequestValidator(new RequestValidator())
            ->setRulesResolver(new RulesResolver())
            ->setSignerResolver($signerResolver)
            ->setSenderResolver($senderResolver)
            ->setResponseValidatorResolver($responseValidatorResolver);
    }

    public function setRequestValidator(RequestValidatorInterface $validator): self
    {
        $this->requestValidator = $validator;
        return $this;
    }

    public function setRulesResolver(RulesResolverInterface $rulesResolver): self
    {
        $this->rulesResolver = $rulesResolver;
        return $this;
    }

    public function setSignerResolver(SignerResolverInterface $signerResolver): self
    {
        $this->signerResolver = $signerResolver;
        return $this;
    }

    public function setSenderResolver(SenderResolverInterface $senderResolver): self
    {
        $this->senderResolver = $senderResolver;
        return $this;
    }

    public function setResponseValidatorResolver(ResponseValidatorResolverInterface $resolver): self
    {
        $this->responseValidatorResolver = $resolver;
        return $this;
    }

    /**
     * @return array<mixed>
     * @throws \Gamemoney\Exception\RequestException
     * @throws \Gamemoney\Exception\ResponseValidationException
     * @throws \Gamemoney\Exception\RequestValidationException
     */
    public function send(RequestInterface $request): array
    {
        if (!preg_match(RequestInterface::STORE_ONLY_CARD_DATA_REGEX, $request->getAction())) {
            if (empty($request->getData()['rand'])) {
                $request->setField('rand', bin2hex(openssl_random_pseudo_bytes(10)));
            }

            $request->setField('project', $this->config->project());
        }

        $rules = $this->rulesResolver->resolve($request->getAction(), $request->getData())->getRules();
        $this->requestValidator->validate($rules, $request->getData());

        $request = $this
            ->signerResolver
            ->resolve($request->getAction())
            ->sign($request);

        $response = $this
            ->senderResolver
            ->resolve($request->getAction())
            ->send($request);

        $this
            ->responseValidatorResolver
            ->resolve($request->getAction())
            ->validate($response, $request->getData());

        return $response;
    }
}
