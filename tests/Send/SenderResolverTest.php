<?php

namespace tests\Send;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\Sender\JsonSender;
use Gamemoney\Send\Sender\Sender;
use Gamemoney\Send\SenderInterface;
use Gamemoney\Send\SenderResolver;
use Gamemoney\Send\SenderResolverInterface;
use PHPUnit\Framework\TestCase;

class SenderResolverTest extends TestCase
{
    const API_URL = 'testUrl';

    const SECURE_URL = 'testSecure';

    const CLIENT_CONFIG = ['test' => '123'];

    public function testInterface()
    {
        $resolver = new SenderResolver($this::API_URL, $this::SECURE_URL, $this::CLIENT_CONFIG);
        $this->assertInstanceOf(SenderResolverInterface::class, $resolver);
    }

    /**
     * @return array
     */
    public function resolveDataProvider()
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

    /**
     * @dataProvider resolveDataProvider
     */
    public function testSenderResolve($action)
    {
        $resolver = new SenderResolver($this::API_URL, $this::SECURE_URL, $this::CLIENT_CONFIG);
        $sender = $resolver->resolve($action);
        $this->assertInstanceOf(SenderInterface::class, $sender);
        $this->assertInstanceOf(Sender::class, $sender);
    }

    public function testSenderSecureResolve()
    {
        $resolver = new SenderResolver($this::API_URL, $this::SECURE_URL, $this::CLIENT_CONFIG);
        $sender = $resolver->resolve('v1/sessions/testToken/input');
        $this->assertInstanceOf(SenderInterface::class, $sender);
        $this->assertInstanceOf(JsonSender::class, $sender);
    }
}
