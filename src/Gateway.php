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
 * Class Gateway
 * See using examples in examples folder
 * @package Gamemoney
 */
class Gateway
{
    /** @var Config */
    private $config;

    /** @var RequestValidatorInterface */
    private $requestValidator;

    /** @var RulesResolverInterface */
    private $rulesResolver;

    /** @var SignerResolverInterface */
    private $signerResolver;

    /** @var SenderResolverInterface */
    private $senderResolver;

    /** @var ResponseValidatorResolverInterface */
    private $responseValidatorResolver;

    /**
     * Gateway constructor.
     * @param Config $gatewayConfig
     * @param array $clientConfig
     * @throws ConfigException
     */
    public function __construct(Config $gatewayConfig, array $clientConfig = [])
    {
        $this->config = $gatewayConfig;

        $signerResolver = new SignerResolver(
            $this->config->hmac(),
            $this->config->privateKey(),
            $this->config->privateKeyPassword()
        );

        $senderResolver = new SenderResolver(
            $this->config->apiUrl(),
            $this->config->secureUrl(),
            $clientConfig
        );

        $responseValidatorResolver = new ResponseValidatorResolver(
            new SignatureVerifier($this->config->gmCertificate())
        );

        $this
            ->setRequestValidator(new RequestValidator())
            ->setRulesResolver(new RulesResolver())
            ->setSignerResolver($signerResolver)
            ->setSenderResolver($senderResolver)
            ->setResponseValidatorResolver($responseValidatorResolver);
    }

    /**
     * @param RequestValidatorInterface $validator
     * @return self
     */
    public function setRequestValidator(RequestValidatorInterface $validator)
    {
        $this->requestValidator = $validator;
        return $this;
    }

    /**
     * @param RulesResolverInterface $rulesResolver
     * @return self
     */
    public function setRulesResolver(RulesResolverInterface $rulesResolver)
    {
        $this->rulesResolver = $rulesResolver;
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
     * @param SenderResolverInterface $senderResolver
     * @return self
     */
    public function setSenderResolver(SenderResolverInterface $senderResolver)
    {
        $this->senderResolver = $senderResolver;
        return $this;
    }

    /**
     * @param ResponseValidatorResolverInterface $resolver
     * @return self
     */
    public function setResponseValidatorResolver(ResponseValidatorResolverInterface $resolver)
    {
        $this->responseValidatorResolver = $resolver;
        return $this;
    }

    /**
     * @param RequestInterface $request
     * @return array
     * @throws \Gamemoney\Exception\RequestException
     * @throws \Gamemoney\Exception\ResponseValidationException
     * @throws \Gamemoney\Exception\RequestValidationException
     */
    public function send(RequestInterface $request)
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
