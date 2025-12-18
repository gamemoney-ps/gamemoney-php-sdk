<?php

namespace tests\Validation\Response;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Sign\SignatureVerifierInterface;
use Gamemoney\Validation\Response\ResponseValidatorInterface;
use Gamemoney\Validation\Response\ResponseValidatorResolver;
use Gamemoney\Validation\Response\ResponseValidatorResolverInterface;
use Gamemoney\Validation\Response\Validator\ResponseValidator;
use Gamemoney\Validation\Response\Validator\ResponseValidatorSecure;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ResponseValidatorResolverTest extends TestCase
{
    public function testInterface(): void
    {
        $mockSignature = $this->getSignatureMock();

        $resolver = new ResponseValidatorResolver($mockSignature);
        $this->assertInstanceOf(ResponseValidatorResolverInterface::class, $resolver);
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
                RequestInterface::CHECKOUT_CREATE_ACTION,
            ],
            [
                RequestInterface::CHECKOUT_CHECK_ACTION,
            ],
            [
                RequestInterface::CHECKOUT_PREPARE_ACTION,
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
    public function testResolve(string $action): void
    {
        $mockSignature = $this->getSignatureMock();

        $resolver = new ResponseValidatorResolver($mockSignature);
        $validator = $resolver->resolve($action);
        $this->assertInstanceOf(ResponseValidatorInterface::class, $validator);
        $this->assertInstanceOf(ResponseValidator::class, $validator);
    }

    public function testStoreOnlyCardDataResolve(): void
    {
        $mockSignature = $this->getSignatureMock();

        $resolver = new ResponseValidatorResolver($mockSignature);
        $validator = $resolver->resolve('v1/sessions/testToken/input');
        $this->assertInstanceOf(ResponseValidatorInterface::class, $validator);
        $this->assertInstanceOf(ResponseValidatorSecure::class, $validator);
    }

    private function getSignatureMock(): SignatureVerifierInterface
    {
        return $this
            ->getMockBuilder(SignatureVerifierInterface::class)
            ->getMock();
    }
}
