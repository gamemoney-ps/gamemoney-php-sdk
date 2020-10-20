<?php
namespace tests\Validation\Request;

use Gamemoney\Validation\Request\Rules\DefaultRules;
use Gamemoney\Validation\Request\RulesInterface;
use Gamemoney\Validation\Request\RulesResolver;
use Gamemoney\Request\RequestInterface;
use PHPUnit\Framework\TestCase;

class RulesResolverTest extends TestCase
{
    /**
     * @return array
     */
    public function resolveProvider()
    {
        return [
            ['action' => RequestInterface::INVOICE_CREATE_ACTION],
            ['action' => RequestInterface::INVOICE_STATUS_ACTION],
            ['action' => RequestInterface::INVOICE_LIST_ACTION],
            ['action' => RequestInterface::CHECKOUT_CANCEL_ACTION],
            ['action' => RequestInterface::CHECKOUT_CREATE_ACTION],
            ['action' => RequestInterface::CHECKOUT_STATUS_ACTION],
            ['action' => RequestInterface::CHECKOUT_LIST_ACTION],
            ['action' => RequestInterface::EXCHANGE_CONVERT_ACTION],
            ['action' => RequestInterface::EXCHANGE_FAST_CONVERT_ACTION],
            ['action' => RequestInterface::EXCHANGE_INFO_ACTION],
            ['action' => RequestInterface::EXCHANGE_PREPARE_ACTION],
            ['action' => RequestInterface::EXCHANGE_STATUS_ACTION],
            ['action' => RequestInterface::CARD_LIST_ACTION],
            ['action' => RequestInterface::CARD_ADD_ACTION],
            ['action' => RequestInterface::CARD_ADDTOKEN_ACTION],
            ['action' => RequestInterface::CARD_DELETE_ACTION],
            ['action' => RequestInterface::STATISTICS_BALANCE_ACTION],
            ['action' => RequestInterface::STATISTICS_DAYS_BALANCE_ACTION],
            ['action' => RequestInterface::STATISTICS_PAY_TYPES_ACTION],
            ['action' => 'v1/sessions/testToken/input'],
            ['action' => 'wrong action'],
        ];
    }

    /**
     * @param string $action
     * @dataProvider resolveProvider
     */
    public function testResolve($action)
    {
        $resolver = new RulesResolver();
        $rules = $resolver->resolve($action, []);

        $this->assertInstanceOf(RulesInterface::class, $rules);
        $this->assertTrue(is_array($rules->getRules()));
    }

    public function testWrongActionResolve()
    {
        $resolver = new RulesResolver();
        $this->assertInstanceOf(DefaultRules::class, $resolver->resolve('wrong action', []));
    }
}
