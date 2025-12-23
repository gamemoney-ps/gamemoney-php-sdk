<?php

namespace Gamemoney;

use Gamemoney\Exception\ConfigException;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\Sender;
use Gamemoney\Send\SenderInterface;
use Gamemoney\Sign\SignatureVerifier;
use Gamemoney\Sign\SignerResolver;
use Gamemoney\Sign\SignerResolverInterface;
use Gamemoney\Validation\Request\RequestValidator;
use Gamemoney\Validation\Request\RequestValidatorInterface;
use Gamemoney\Validation\Request\RulesResolver;
use Gamemoney\Validation\Request\RulesResolverInterface;
use Gamemoney\Validation\Response\ResponseValidator;
use Gamemoney\Validation\Response\ResponseValidatorInterface;

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

    private SenderInterface $sender;

    private ResponseValidatorInterface $responseValidator;

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

        $this
            ->setRequestValidator(new RequestValidator())
            ->setRulesResolver(new RulesResolver())
            ->setSignerResolver($signerResolver)
            ->setSender(
                new Sender($this->config->apiUrl(), $clientConfig),
            )
            ->setResponseValidator(
                new ResponseValidator(
                    new SignatureVerifier($this->config->getCertificate()),
                ),
            );
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

    public function setSender(SenderInterface $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    public function setResponseValidator(ResponseValidatorInterface $responseValidator): self
    {
        $this->responseValidator = $responseValidator;
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
        if (empty($request->getData()['rand'])) {
            $request->setField('rand', bin2hex(openssl_random_pseudo_bytes(10)));
        }

        $request->setField('project', $this->config->project());

        $rules = $this->rulesResolver->resolve($request->getAction(), $request->getData())->getRules();
        $this->requestValidator->validate($rules, $request->getData());

        $request = $this
            ->signerResolver
            ->resolve($request->getAction())
            ->sign($request);

        $response = $this->sender->send($request);

        $this->responseValidator->validate($response, $request->getData());

        return $response;
    }
}
