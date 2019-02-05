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
        $this->assertInstanceOf(SignerResolverInterface::class, $resolver);
    }

    public function resolveDataProvider()
    {
        return [
            [
                RequestInterface::INVOICE_CREATE_ACTION
            ],
            [
                RequestInterface::INVOICE_STATUS_ACTION
            ],
            [
                RequestInterface::INVOICE_LIST_ACTION
            ],
            [
                RequestInterface::CHECKOUT_CANCEL_ACTION
            ],
            [
                RequestInterface::CHECKOUT_STATUS_ACTION
            ],
            [
                RequestInterface::CARD_ADD_ACTION
            ],
            [
                RequestInterface::CARD_LIST_ACTION
            ],
            [
                RequestInterface::CARD_DELETE_ACTION
            ],
            [
                RequestInterface::EXCHANGE_PREPARE_ACTION
            ],
            [
                RequestInterface::EXCHANGE_INFO_ACTION
            ],
            [
                RequestInterface::EXCHANGE_CONVERT_ACTION
            ],
            [
                RequestInterface::EXCHANGE_FAST_CONVERT_ACTION
            ],
            [
                RequestInterface::EXCHANGE_STATUS_ACTION
            ],
            [
                RequestInterface::STATISTICS_BALANCE_ACTION
            ],
            [
                RequestInterface::STATISTICS_DAYS_BALANCE_ACTION
            ],
            [
                'any other action'
            ]
        ];
    }

    /**
     * @dataProvider resolveDataProvider
     */
    public function testHmacResolve($action)
    {
        $resolver = new SignerResolver($this->hmacKey, $this->privateKey, $this->passphrase);
        $signer = $resolver->resolve($action);
        $this->assertInstanceOf(SignerInterface::class, $signer);
        $this->assertInstanceOf(HmacSigner::class, $signer);
    }

    public function testRsaResolve()
    {
        $resolver = new SignerResolver($this->hmacKey, $this->privateKey, $this->passphrase);
        $signer = $resolver->resolve(RequestInterface::CHECKOUT_CREATE_ACTION);
        $this->assertInstanceOf(SignerInterface::class, $signer);
        $this->assertInstanceOf(RsaSigner::class, $signer);
    }
}
