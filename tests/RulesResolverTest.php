<?php
namespace tests;

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
            ['action' => RequestInterface::INVOICE_CREATE_ACTION, 'data' => []],
            ['action' => RequestInterface::INVOICE_STATUS_ACTION, 'data' => ['invoice' => 123]],
            ['action' => RequestInterface::INVOICE_STATUS_ACTION, 'data' => ['project_invoice' => 'test']],
            ['action' => RequestInterface::INVOICE_LIST_ACTION, 'data' => []],
            ['action' => RequestInterface::CHECKOUT_CANCEL_ACTION, 'data' => []],
            ['action' => RequestInterface::CHECKOUT_CREATE_ACTION, 'data' => []],
            ['action' => RequestInterface::CHECKOUT_STATUS_ACTION, 'data' => []],
            ['action' => RequestInterface::CHECKOUT_LIST_ACTION, 'data' => []],
            ['action' => RequestInterface::EXCHANGE_CONVERT_ACTION, 'data' => []],
            ['action' => RequestInterface::EXCHANGE_FAST_CONVERT_ACTION, 'data' => []],
            ['action' => RequestInterface::EXCHANGE_INFO_ACTION, 'data' => []],
            ['action' => RequestInterface::EXCHANGE_PREPARE_ACTION, 'data' => []],
            ['action' => RequestInterface::EXCHANGE_STATUS_ACTION, 'data' => []],
            ['action' => RequestInterface::CARD_LIST_ACTION, 'data' => []],
            ['action' => RequestInterface::CARD_ADD_ACTION, 'data' => []],
            ['action' => RequestInterface::CARD_DELETE_ACTION, 'data' => []],
            ['action' => RequestInterface::STATISTICS_BALANCE_ACTION, 'data' => []],
            ['action' => RequestInterface::STATISTICS_DAYS_BALANCE_ACTION, 'data' => []],
            ['action' => RequestInterface::STATISTICS_PAY_TYPES_ACTION, 'data' => []],
            ['action' => 'wrong action', 'data' => []],
        ];
    }

    /**
     * @param string $action
     * @dataProvider resolveProvider
     */
    public function testResolve($action, array $data)
    {
        $resolver = new RulesResolver();
        $rules = $resolver->resolve($action, $data);

        $this->assertInstanceOf(RulesInterface::class, $rules);

        $this->assertInternalType('array', $rules->getRules());
    }

    public function testWrongActionResolve()
    {
        $resolver = new RulesResolver();
        $this->assertInstanceOf(DefaultRules::class, $resolver->resolve('wrong action', []));
    }
}
