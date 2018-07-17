<?php
namespace Gamemoney;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Request\Request;
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
    private $id;
    /** @var  ValidatorResolverInterface */
    private $validatorResolver;
    /** @var  SenderInterface */
    private $sender;

    public function __construct($config)
    {
        if(empty($config['apiUrl'])) {
            $config['apiUrl'] = self::API_URL;
        }

        if(empty($config['id'])) {
            throw new ConfigException('Project id is not set');
        }

        $signerResolver = new SignerResolver($config);
        $sender = new Sender($config, $signerResolver);

        $this->id = $config['id'];
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
        $this->modifyRequestData($request);
        $validator = $this->validatorResolver->resolve($request->getAction());
        $validator->validate($request->getData());

        return $this->sender->send($request);
    }

    /**
     * Add project Id and rand param
     * @param  RequestInterface $request [description]
     * @return array
     */
    private function modifyRequestData(RequestInterface $request)
    {
        $data = $request->getData();
        if (empty($data['rand'])) {
            $data['rand'] = bin2hex(openssl_random_pseudo_bytes((10)));
        }

        $data['project'] = $this->id;
        $request->setData($data);
    }
}