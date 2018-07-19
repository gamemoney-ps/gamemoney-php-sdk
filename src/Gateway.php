<?php
namespace Gamemoney;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\Sender;
use Gamemoney\Send\SenderInterface;
use Gamemoney\Exception\ConfigException;
use Gamemoney\Validation\Validator;
use Gamemoney\Validation\ValidatorInterface;
use Gamemoney\Validation\RulesResolver;
use Gamemoney\Validation\RulesResolverInterface;
use Gamemoney\Sign\SignerResolver;

class Gateway
{
    const API_URL = 'https://paygate.gamemoney.com';

    /** @var int */
    private $project;
    /** @var  ValidatorInterface */
    private $validator;
    /** @var  RulesResolverInterface */
    private $rulesResolver;
    /** @var  SenderInterface */
    private $sender;

    public function __construct($config)
    {
        if(empty($config['apiUrl'])) {
            $config['apiUrl'] = self::API_URL;
        }

        if(empty($config['project'])) {
            throw new ConfigException('Project id is not set');
        }

        if(empty($config['hmacKey'])) {
            throw new ConfigException('Project id is not set');
        }

        $hmacKey = $config['hmacKey'];

        if(empty($config['privateKey'])) {
            throw new ConfigException('privateKey id is not set');
        }

        $privateKey = $config['privateKey'];
        if(!is_resource($privateKey)) {
            throw new ConfigException('privateKey must be resourse (openssl_pkey_get_private)');
        }

        $signerResolver = new SignerResolver($hmacKey, $privateKey);

        if(empty($config['clientConfig'])) {
            $config['clientConfig'] = [];
        }

        $sender = new Sender($config['apiUrl'], $signerResolver, $config['clientConfig']);

        $this->project = $config['project'];
        $this
            ->setValidator(new Validator)
            ->setRulesResolver(new RulesResolver)
            ->setSender($sender);
    }

    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;
        return $this;
    }

    public function setRulesResolver(RulesResolverInterface $rulesResolver)
    {
        $this->rulesResolver = $rulesResolver;
        return $this;
    }

    public function setSender(SenderInterface $sender)
    {
        $this->sender = $sender;
        return $this;
    }

    public function send(RequestInterface $request)
    {
        $request->setField('project', $this->project);
        $rules = $this->rulesResolver->resolve($request->getAction())->getRules();
        $this->validator->validate($rules, $request->getData());
        return $this->sender->send($request);
    }
}