<?php

namespace tests\Request;

use Gamemoney\Request\RequestFactory;
use Gamemoney\Request\RequestInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class RequestFactoryTest extends TestCase
{
    public static function methodDataProvider(): array
    {
        return [
            [
                'createInvoice',
                RequestInterface::INVOICE_CREATE_ACTION,
            ],
            [
                'getInvoiceStatus',
                RequestInterface::INVOICE_STATUS_ACTION,
            ],
            [
                'getInvoiceList',
                RequestInterface::INVOICE_LIST_ACTION,
            ],
            [
                'createCheckout',
                RequestInterface::CHECKOUT_CREATE_ACTION,
            ],
            [
                'checkCheckout',
                RequestInterface::CHECKOUT_CHECK_ACTION,
            ],
            [
                'prepareCheckout',
                RequestInterface::CHECKOUT_PREPARE_ACTION,
            ],
            [
                'cancelCheckout',
                RequestInterface::CHECKOUT_CANCEL_ACTION,
            ],
            [
                'getCheckoutStatus',
                RequestInterface::CHECKOUT_STATUS_ACTION,
            ],
            [
                'getCheckoutList',
                RequestInterface::CHECKOUT_LIST_ACTION,
            ],
            [
                'addCard',
                RequestInterface::CARD_ADD_ACTION,
            ],
            [
                'getCardList',
                RequestInterface::CARD_LIST_ACTION,
            ],
            [
                'getCardFulllist',
                RequestInterface::CARD_FULL_LIST_ACTION,
            ],
            [
                'deleteCard',
                RequestInterface::CARD_DELETE_ACTION,
            ],
            [
                'addtokenCard',
                RequestInterface::CARD_ADD_TOKEN_ACTION,
            ],
            [
                'prepareExchange',
                RequestInterface::EXCHANGE_PREPARE_ACTION,
            ],
            [
                'convertExchange',
                RequestInterface::EXCHANGE_CONVERT_ACTION,
            ],
            [
                'fastConvertExchange',
                RequestInterface::EXCHANGE_FAST_CONVERT_ACTION,
            ],
            [
                'getExchangeRate',
                RequestInterface::EXCHANGE_RATE_ACTION,
            ],
            [
                'getExchangeStatus',
                RequestInterface::EXCHANGE_STATUS_ACTION,
            ],
            [
                'getBalanceStatistics',
                RequestInterface::STATISTICS_BALANCE_ACTION,
            ],
            [
                'getDaysBalanceStatistics',
                RequestInterface::STATISTICS_DAYS_BALANCE_ACTION,
            ],
            [
                'addTokenInvoice',
                RequestInterface::INVOICE_ADD_TOKEN_ACTION,
            ],
            [
                'createTerminal',
                RequestInterface::TERMINAL_CREATE_ACTION,
            ],
        ];
    }

    #[DataProvider('methodDataProvider')]
    public function testMethods(string $method, string $action): void
    {
        $data = [
            'key' => 'value',
        ];

        $requestFactory = new RequestFactory();
        $request = $requestFactory->$method($data);

        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertEquals($request->getAction(), $action);

        $requestData = $request->getData();
        unset($requestData['rand']);
        $this->assertEquals($data, $requestData);
    }

    public function getPayTypesStatisticsTest(): void
    {
        $request = (new RequestFactory())->getPayTypesStatistics();

        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertEquals(RequestInterface::STATISTICS_PAY_TYPES_ACTION, $request->getAction());
        $this->assertNull($request->getData());
    }
}
