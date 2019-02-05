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
    const API_URL = 'https://paygate.gamemoney.com';

    /** @var int */
    private $project;
    /** @var  RequestValidatorInterface */
    private $requestValidator;
    /** @var  ResponseValidatorInterface */
    private $responseValidator;
    /** @var  RulesResolverInterface */
    private $rulesResolver;
    /** @var  SenderInterface */
    private $sender;
    /** @var  SignerResolverInterface */
    private $signerResolver;

    /**
     * Gateway constructor.
     * @param array $config
     * @throws ConfigException
     */
    public function __construct($config)
    {
        if(empty($config['apiUrl'])) {
            $config['apiUrl'] = self::API_URL;
        }

        if(empty($config['project'])) {
            throw new ConfigException('Project id is not set');
        }

        if(empty($config['hmacKey'])) {
            throw new ConfigException('hmacKey is not set');
        }

        if(empty($config['privateKey'])) {
            $config['privateKey'] = null;
        }

        if(empty($config['apiPublicKey'])) {
            throw new ConfigException('apiPublicKey is not set');
        }

        if(empty($config['passphrase'])) {
            $config['passphrase'] = '';
        }

        $signerResolver = new SignerResolver(
            $config['hmacKey'],
            $config['privateKey'],
            $config['passphrase']
        );

        if(empty($config['clientConfig'])) {
            $config['clientConfig'] = [];
        }

        $sender = new Sender($config['apiUrl'], $config['clientConfig']);

        $this->project = $config['project'];
        $this
            ->setRequestValidator(new RequestValidator)
            ->setResponseValidator(new ResponseValidator(new SignatureVerifier($config['apiPublicKey'])))
            ->setRulesResolver(new RulesResolver)
            ->setSignerResolver($signerResolver)
            ->setSender($sender);
    }

    /**
     * @param RequestValidatorInterface $validator
     * @return $this
     */
    public function setRequestValidator(RequestValidatorInterface $validator)
    {
        $this->requestValidator = $validator;
        return $this;
    }

    /**
     * @param ResponseValidatorInterface $validator
     * @return $this
     */
    public function setResponseValidator(ResponseValidatorInterface $validator)
    {
        $this->responseValidator = $validator;
        return $this;
    }

    /**
     * @param RulesResolverInterface $rulesResolver
     * @return $this
     */
    public function setRulesResolver(RulesResolverInterface $rulesResolver)
    {
        $this->rulesResolver = $rulesResolver;
        return $this;
    }

    /**
     * @param SenderInterface $sender
     * @return $this
     */
    public function setSender(SenderInterface $sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @param SignerResolverInterface $signerResolver
     * @return $this
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
     * @throws \Gamemoney\Exception\RequestValidationException
     * @throws \Gamemoney\Exception\ResponseValidationException
     */
    public function send(RequestInterface $request)
    {
        $request->setField('project', $this->project);
        $rules = $this->rulesResolver->resolve($request->getAction())->getRules();
        $this->requestValidator->validate($rules, $request->getData());

        $signer = $this->signerResolver->resolve($request->getAction());
        $request->setField('signature', $signer->getSignature($request->getData()));

        $response = $this->sender->send($request);
        $this->responseValidator->validate($response, $request->getData());
        return $response;
    }
}
