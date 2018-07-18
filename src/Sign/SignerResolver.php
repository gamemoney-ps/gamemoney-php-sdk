<?php
namespace Gamemoney\Sign;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Exception\ConfigException;
use Gamemoney\Sign\Signer\RsaSigner;
use Gamemoney\Sign\Signer\HmacSigner;

class SignerResolver implements SignerResolverInterface
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $action
     * @return SignerInterface
     * @throws ConfigException
     */
    public function resolve($action)
    {
        $config = $this->config;

        if ($action === RequestInterface::CHECKOUT_CREATE_ACTION) {

            if(empty($config['rsaKey'])) {
                throw new ConfigException('rsaKey is not set');
            }

            if(empty($config['passphrase'])) {
                $config['passphrase'] = '';
            }

            return new RsaSigner($config['rsaKey'], $config['passphrase']);
        }

        if(empty($config['hmacKey'])) {
            throw new ConfigException('hmacKey is not set');
        }

        return new HmacSigner($config['hmacKey']);
    }
}