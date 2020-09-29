<?php

namespace Gamemoney\Config\Secure;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\Sender;
use Gamemoney\Send\SenderInterface;
use Gamemoney\Validation\Request\RequestValidator;
use Gamemoney\Validation\Request\RequestValidatorInterface;
use Gamemoney\Validation\Request\RulesResolver;
use Gamemoney\Validation\Request\RulesResolverInterface;

class Gateway
{
    /** @var Config */
    private $config;

    /** @var RequestValidatorInterface */
    private $requestValidator;

    /** @var RulesResolverInterface */
    private $rulesResolver;

    /** @var SenderInterface */
    private $sender;

    /**
     * Gateway constructor.
     * @param Config $gatewayConfig
     */
    public function __construct(Config $gatewayConfig)
    {
        $this->config = $gatewayConfig;

        $sender = new Sender($this->config->apiUrl(), []);

        $this
            ->setRequestValidator(new RequestValidator)
            ->setRulesResolver(new RulesResolver)
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
     * @param RequestInterface $request
     * @return array
     * @throws \Gamemoney\Exception\RequestException
     * @throws \Gamemoney\Exception\RequestValidationException
     */
    public function send(RequestInterface $request)
    {
        $rules = $this->rulesResolver->resolve($request->getAction(), $request->getData())->getRules();
        $this->requestValidator->validate($rules, $request->getData());

        $response = $this->sender->send($request);

        return $response;
    }
}
