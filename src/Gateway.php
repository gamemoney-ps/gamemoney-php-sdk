<?php
namespace Gamemoney;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\Sender;
use Gamemoney\Send\SenderInterface;
use Gamemoney\Exception\ConfigException;
use Gamemoney\Sign\SignatureVerifier;
use Gamemoney\Sign\SignerResolverInterface;
use Gamemoney\Validation\Request\RequestValidator;
use Gamemoney\Validation\Request\RequestValidatorInterface;
use Gamemoney\Validation\Response\ResponseValidator;
use Gamemoney\Validation\Response\ResponseValidatorInterface;
use Gamemoney\Validation\Request\RulesResolver;
use Gamemoney\Validation\Request\RulesResolverInterface;
use Gamemoney\Sign\SignerResolver;

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

    /** @var ResponseValidatorInterface */
    private $responseValidator;

    /** @var RulesResolverInterface */
    private $rulesResolver;

    /** @var SenderInterface */
    private $sender;

    /** @var SignerResolverInterface */
    private $signerResolver;

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

        $sender = new Sender($this->config->apiUrl(), $clientConfig);

        $this
            ->setRequestValidator(new RequestValidator)
            ->setResponseValidator(new ResponseValidator(new SignatureVerifier($this->config->gmCertificate())))
            ->setRulesResolver(new RulesResolver)
            ->setSignerResolver($signerResolver)
            ->setSender($sender);
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
     * @param ResponseValidatorInterface $validator
     * @return self
     */
    public function setResponseValidator(ResponseValidatorInterface $validator)
    {
        $this->responseValidator = $validator;
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
     * @param SenderInterface $sender
     * @return self
     */
    public function setSender(SenderInterface $sender)
    {
        $this->sender = $sender;
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
     * @param RequestInterface $request
     * @return array
     * @throws \Gamemoney\Exception\RequestException
     * @throws \Gamemoney\Exception\ResponseValidationException
     * @throws \Gamemoney\Exception\RequestValidationException
     */
    public function send(RequestInterface $request)
    {
        $request->setField('project', $this->config->project());
        $rules = $this->rulesResolver->resolve($request->getAction(), $request->getData())->getRules();
        $this->requestValidator->validate($rules, $request->getData());

        $signer = $this->signerResolver->resolve($request->getAction());
        $request->setField('signature', $signer->getSignature($request->getData()));

        $response = $this->sender->send($request);
        $this->responseValidator->validate($response, $request->getData());

        return $response;
    }
}
