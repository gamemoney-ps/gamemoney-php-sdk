<?php
namespace Gamemoney;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\Sender;
use Gamemoney\Send\SenderInterface;
use Gamemoney\Exception\ConfigException;
use Gamemoney\Validation\ValidatorResolver;
use Gamemoney\Validation\ValidatorResolverInterface;
use Gamemoney\Sign\SignerResolver;

class Gateway
{
    const API_URL = 'https://paygate.gamemoney.com';

    /** @var int */
    private $project;
    /** @var  ValidatorResolverInterface */
    private $validatorResolver;
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

        $signerResolver = new SignerResolver($config);
        $sender = new Sender($config, $signerResolver);

        $this->project = $config['project'];
        $this
            ->setValidatorResolver(new ValidatorResolver)
            ->setSender($sender);
    }

    public function setValidatorResolver(ValidatorResolverInterface $validatorResolver)
    {
        $this->validatorResolver = $validatorResolver;
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
        $validator = $this->validatorResolver->resolve($request->getAction());
        $validator->validate($request->getData());

        return $this->sender->send($request);
    }
}