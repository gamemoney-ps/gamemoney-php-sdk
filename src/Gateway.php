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

    /**
     * @var int
     */
    private $id;
    private $validatorResolver;
    private $sender;

    public function __construct($config)
    {
        if(empty($config['apiUrl'])) {
            $config['apiUrl'] = self::API_URL;
        }

        if(empty($config['id'])) {
            throw new ConfigException('rsaKey is not set');
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

    public function getInvoiceStatus($array)
    {
        $request = new Request(
            RequestInterface::INVOICE_STATUS_ACTION,
            $this->modifyRequestData($array)
        );

        return $this->send($request);
    }

    private function send(RequestInterface $request)
    {
        $validationStrategy = $this->validatorResolver->resolve($request->getAction());
        if (!$validationStrategy->validate($request->getData())) {
            throw new ValidateException();
        }

        return $this->sender->send($request);
    }

    /**
     * Add project Id and rand param
     * @param  array  $data [description]
     * @return array
     */
    private function modifyRequestData(array $data)
    {
        if (empty($data['rand'])) {
            $data['rand'] = bin2hex(openssl_random_pseudo_bytes((10)));
        }

        return array_merge($data, ['project' => $this->id]);
    }
}