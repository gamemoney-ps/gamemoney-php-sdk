<?php
namespace tests;

use Gamemoney\Validation\Rules\DefaultRules;
use Gamemoney\Validation\RulesInterface;
use Gamemoney\Validation\RulesResolver;
use Gamemoney\Request\RequestInterface;
use PHPUnit\Framework\TestCase;


class RulesResolverTest extends TestCase
{
    public function resolveProvider()
    {
        return [
            ['action' => RequestInterface::INVOICE_CREATE_ACTION],
            ['action' => RequestInterface::INVOICE_STATUS_ACTION],
            ['action' => RequestInterface::CHECKOUT_CANCEL_ACTION],
            ['action' => RequestInterface::CHECKOUT_CHECK_ACTION],
            ['action' => RequestInterface::CHECKOUT_CREATE_ACTION],
            ['action' => RequestInterface::CHECKOUT_STATUS_ACTION],
            ['action' => RequestInterface::EXCHANGE_CONVERT_ACTION],
            ['action' => RequestInterface::EXCHANGE_FAST_CONVERT_ACTION],
            ['action' => RequestInterface::EXCHANGE_INFO_ACTION],
            ['action' => RequestInterface::EXCHANGE_PREPARE_ACTION],
            ['action' => RequestInterface::EXCHANGE_STATUS_ACTION],
            ['action' => RequestInterface::CARD_LIST_ACTION],
            ['action' => RequestInterface::CARD_ADD_ACTION],
            ['action' => RequestInterface::CARD_DELETE_ACTION],
            ['action' => RequestInterface::STATISTICS_BALANCE_ACTION],
            ['action' => RequestInterface::STATISTICS_DAYS_BALANCE_ACTION],
            ['action' => RequestInterface::STATISTICS_PAY_TYPES_ACTION],
            ['action' => 'wrong action'],
        ];
    }
    /**
     * @param $action
     * @dataProvider resolveProvider
     */
    public function testResolve($action)
    {
        $resolver = new RulesResolver();
        $rules = $resolver->resolve($action);
        $this->assertInstanceOf(RulesInterface::class, $rules);
        $this->assertTrue(is_array($rules->getRules()));
    }

    public function testWrongActionResolve()
    {
        $resolver = new RulesResolver();
        $this->assertInstanceOf(DefaultRules::class, $resolver->resolve('wrong action'));
    }
}