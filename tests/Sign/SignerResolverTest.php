<?php
namespace tests\Sign;

use PHPUnit\Framework\TestCase;
use Gamemoney\Sign\SignerResolver;
use Gamemoney\Sign\SignerResolverInterface;
use Gamemoney\Sign\SignerInterface;
use Gamemoney\Sign\Signer\HmacSigner;
use Gamemoney\Sign\Signer\RsaSigner;
use Gamemoney\Request\RequestInterface;

class SignerResolverTest extends TestCase {

    private $hmacKey;
    private $privateKey;
    private $passphrase;

    protected function setUp()
    {
        $this->hmacKey = '123';
        $this->privateKey = '--1233--';
        $this->passphrase = '123';
    }

    public function testInterface()
    {
        $resolver = new SignerResolver($this->hmacKey, $this->privateKey, $this->passphrase);
        $this->isInstanceOf($resolver, SignerResolverInterface::class);
    }

    public function testHmacResolve()
    {
        $resolver = new SignerResolver($this->hmacKey, $this->privateKey, $this->passphrase);
        $signer = $resolver->resolve('');
        $this->isInstanceOf($signer, SignerInterface::class);
        $this->isInstanceOf($signer, HmacSigner::class);
    }

    public function testRsaResolve()
    {
        $resolver = new SignerResolver($this->hmacKey, $this->privateKey, $this->passphrase);
        $signer = $resolver->resolve(RequestInterface::CHECKOUT_CREATE_ACTION);
        $this->isInstanceOf($signer, SignerInterface::class);
        $this->isInstanceOf($signer, RsaSigner::class);
    }
}
