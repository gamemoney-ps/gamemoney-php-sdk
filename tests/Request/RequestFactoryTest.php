<?php

namespace tests\Request;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Request\RequestFactory;

class RequestFactoryTest extends TestCase
{
    public static function methodDataProvider(): array
    {
        return [
            [
                'createInvoice',
                [
                    'amount' => 100,
                ],
                RequestInterface::INVOICE_CREATE_ACTION,
                [
                    'amount' => 100,
                ],
            ],
            [
                'getInvoiceStatus',
                1,
                RequestInterface::INVOICE_STATUS_ACTION,
                [
                    'invoice' => 1,
                ],
            ],
            [
                'getInvoiceStatusByExternalId',
                'external_id',
                RequestInterface::INVOICE_STATUS_ACTION,
                [
                    'project_invoice' => 'external_id',
                ],
            ],
            [
                'getInvoiceList',
                [
                    'start' => '2018-10-01 12:10:05',
                    'finish' => '2018-10-30 12:00:00',
                ],
                RequestInterface::INVOICE_LIST_ACTION,
                [
                    'start' => '2018-10-01 12:10:05',
                    'finish' => '2018-10-30 12:00:00',
                ],
            ],
            [
                'createCheckout',
                [
                    'amount' => 100,
                ],
                RequestInterface::CHECKOUT_CREATE_ACTION,
                [
                    'amount' => 100,
                ],
            ],
            [
                'checkCheckout',
                [
                    'amount' => 100,
                ],
                RequestInterface::CHECKOUT_CHECK_ACTION,
                [
                    'amount' => 100,
                ],
            ],
            [
                'prepareCheckout',
                [
                    'amount' => 100,
                ],
                RequestInterface::CHECKOUT_PREPARE_ACTION,
                [
                    'amount' => 100,
                ],
            ],
            [
                'cancelCheckout',
                1,
                RequestInterface::CHECKOUT_CANCEL_ACTION,
                [
                    'projectId' => 1,
                ],
            ],
            [
                'getCheckoutStatus',
                1,
                RequestInterface::CHECKOUT_STATUS_ACTION,
                [
                    'projectId' => 1,
                ],
            ],
            [
                'getCheckoutList',
                [
                    'start' => '2018-10-01 12:10:05',
                    'finish' => '2018-10-30 12:00:00',
                ],
                RequestInterface::CHECKOUT_LIST_ACTION,
                [
                    'start' => '2018-10-01 12:10:05',
                    'finish' => '2018-10-30 12:00:00',
                ],
            ],
            [
                'addCard',
                [
                    'user' => 1,
                ],
                RequestInterface::CARD_ADD_ACTION,
                [
                    'user' => 1,
                ],
            ],
            [
                'getCardList',
                1,
                RequestInterface::CARD_LIST_ACTION,
                [
                    'user' => 1,
                ],
            ],
            [
                'getCardFulllist',
                1,
                RequestInterface::CARD_FULLLIST_ACTION,
                [
                    'user' => 1,
                ],
            ],
            [
                'deleteCard',
                [
                    'pan' => '1111****3333',
                ],
                RequestInterface::CARD_DELETE_ACTION,
                [
                    'pan' => '1111****3333',
                ],
            ],
            [
                'addtokenCard',
                [
                    'user' => 1,
                ],
                RequestInterface::CARD_ADDTOKEN_ACTION,
                [
                    'user' => 1,
                ],
            ],
            [
                'prepareExchange',
                [
                    'amount' => 100,
                ],
                RequestInterface::EXCHANGE_PREPARE_ACTION,
                [
                    'amount' => 100,
                ],
            ],
            [
                'convertExchange',
                [
                    'amount' => 100,
                ],
                RequestInterface::EXCHANGE_CONVERT_ACTION,
                [
                    'amount' => 100,
                ],
            ],
            [
                'fastConvertExchange',
                [
                    'amount' => 100,
                ],
                RequestInterface::EXCHANGE_FAST_CONVERT_ACTION,
                [
                    'amount' => 100,
                ],
            ],
            [
                'getExchangeRate',
                [
                    'from' => 'USD',
                    'to' => 'RUB',
                ],
                RequestInterface::EXCHANGE_RATE_ACTION,
                [
                    'from' => 'USD',
                    'to' => 'RUB',
                ],
            ],
            [
                'getExchangeStatus',
                1,
                RequestInterface::EXCHANGE_STATUS_ACTION,
                [
                    'id' => 1,
                ],
            ],
            [
                'getExchangeStatusByExternalId',
                'external_id',
                RequestInterface::EXCHANGE_STATUS_ACTION,
                [
                    'externalId' => 'external_id',
                ],
            ],
            [
                'getBalanceStatistics',
                'RUB',
                RequestInterface::STATISTICS_BALANCE_ACTION,
                [
                    'currency' => 'RUB',
                ],
            ],
            [
                'getDaysBalanceStatistics',
                [
                    'currency' => 'RUB',
                    'start' => '2018-10-01',
                    'finish' => '2018-10-30',
                ],
                RequestInterface::STATISTICS_DAYS_BALANCE_ACTION,
                [
                    'currency' => 'RUB',
                    'start' => '2018-10-01',
                    'finish' => '2018-10-30',
                ],
            ],
            [
                'getPayTypesStatistics',
                [],
                RequestInterface::STATISTICS_PAY_TYPES_ACTION,
                [],
            ],
            [
                'createTerminal',
                [
                    'user' => 1,
                    'ip' => '72.14.192.0',
                    'add_some_field' => 'some value',
                ],
                RequestInterface::TERMINAL_CREATE_ACTION,
                [
                    'user' => 1,
                    'ip' => '72.14.192.0',
                    'add_some_field' => 'some value',
                ],
            ],
        ];
    }

    #[DataProvider('methodDataProvider')]
    public function testMethods(string $method, int|string|array $args, string $action, array $expectedData): void
    {
        $requestFactory = new RequestFactory();
        $request = $requestFactory->$method($args);

        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertEquals($request->getAction(), $action);

        $requestData = $request->getData();
        unset($requestData['rand']);
        $this->assertEquals($requestData, $expectedData);
    }

    public function createInvoiceCardSessionTest(): void
    {
        $project = 10;
        $user = 'test_user';

        $data = [
            'project' => $project,
            'user' => $user,
        ];

        $request = (new RequestFactory())->createInvoiceCardSession($project, $user);

        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertEquals(RequestInterface::INVOICE_CREATE_CARD_SESSION, $request->getAction());
        $this->assertEquals($data, $request->getData());
    }
}
