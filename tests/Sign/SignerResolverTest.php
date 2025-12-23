<?php

namespace tests\Sign;

use Gamemoney\Exception\ConfigException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Gamemoney\Sign\SignerResolver;
use Gamemoney\Sign\SignerResolverInterface;
use Gamemoney\Sign\SignerInterface;
use Gamemoney\Sign\Signer\HmacSigner;
use Gamemoney\Sign\Signer\RsaSigner;
use Gamemoney\Request\RequestInterface;

class SignerResolverTest extends TestCase
{
    const HMAC_KEY = '123';

    const PRIVATE_KEY = '--1233--';

    const PASSPHRASE = '123';

    public function testInterface(): void
    {
        $resolver = new SignerResolver($this::HMAC_KEY, $this::PRIVATE_KEY, $this::PASSPHRASE);
        $this->assertInstanceOf(SignerResolverInterface::class, $resolver);
    }

    public static function resolveDataProvider(): array
    {
        return [
            [
                RequestInterface::INVOICE_CREATE_ACTION,
            ],
            [
                RequestInterface::INVOICE_STATUS_ACTION,
            ],
            [
                RequestInterface::INVOICE_LIST_ACTION,
            ],
            [
                RequestInterface::INVOICE_CREATE_CARD_SESSION,
            ],
            [
                RequestInterface::CHECKOUT_CANCEL_ACTION,
            ],
            [
                RequestInterface::CHECKOUT_STATUS_ACTION,
            ],
            [
                RequestInterface::CHECKOUT_LIST_ACTION,
            ],
            [
                RequestInterface::CARD_ADD_ACTION,
            ],
            [
                RequestInterface::CARD_ADDTOKEN_ACTION,
            ],
            [
                RequestInterface::CARD_LIST_ACTION,
            ],
            [
                RequestInterface::CARD_DELETE_ACTION,
            ],
            [
                RequestInterface::EXCHANGE_PREPARE_ACTION,
            ],
            [
                RequestInterface::EXCHANGE_RATE_ACTION,
            ],
            [
                RequestInterface::EXCHANGE_CONVERT_ACTION,
            ],
            [
                RequestInterface::EXCHANGE_FAST_CONVERT_ACTION,
            ],
            [
                RequestInterface::EXCHANGE_STATUS_ACTION,
            ],
            [
                RequestInterface::STATISTICS_BALANCE_ACTION,
            ],
            [
                RequestInterface::STATISTICS_DAYS_BALANCE_ACTION,
            ],
            [
                RequestInterface::STATISTICS_PAY_TYPES_ACTION,
            ],
            [
                RequestInterface::TERMINAL_CREATE_ACTION,
            ],
            [
                'any other action',
            ],
        ];
    }

    #[DataProvider('resolveDataProvider')]
    public function testHmacResolve(string $action): void
    {
        $resolver = new SignerResolver(self::HMAC_KEY, null, null);
        $signer = $resolver->resolve($action);
        $this->assertInstanceOf(SignerInterface::class, $signer);
        $this->assertInstanceOf(HmacSigner::class, $signer);
    }

    public static function resolveRsaDataProvider(): array
    {
        return [
            [
                RequestInterface::CHECKOUT_CREATE_ACTION,
            ],
            [
                RequestInterface::CHECKOUT_CHECK_ACTION,
            ],
        ];
    }

    #[DataProvider('resolveRsaDataProvider')]
    public function testRsaResolve(string $action): void
    {
        $resolver = new SignerResolver(self::HMAC_KEY, self::PRIVATE_KEY, self::PASSPHRASE);
        $signer = $resolver->resolve($action);
        $this->assertInstanceOf(SignerInterface::class, $signer);
        $this->assertInstanceOf(RsaSigner::class, $signer);
    }

    public function testPrivateKeyNotSet(): void
    {
        $this->expectException(ConfigException::class);

        $resolver = new SignerResolver($this::HMAC_KEY, null, $this::PASSPHRASE);
        $resolver->resolve(RequestInterface::CHECKOUT_CREATE_ACTION);
    }
}
