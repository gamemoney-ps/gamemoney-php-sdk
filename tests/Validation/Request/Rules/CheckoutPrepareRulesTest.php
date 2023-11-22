<?php

namespace Validation\Request\Rules;

use Gamemoney\Validation\Request\Rules\CheckoutPrepareRules;
use PHPUnit\Framework\TestCase;

class CheckoutPrepareRulesTest extends TestCase
{
    /**
    * @return array
    */
    public function checkoutPrepareProvider()
    {
        return [
            [
                'checkField' => ['project', 'rand', 'type', 'currency', 'paid_amount', 'userCurrency'],
                'data' => [
                    'paid_amount' => 123456,
                ],
            ],
            [
                'checkField' => ['project', 'rand', 'type', 'currency', 'amount', 'userCurrency'],
                'data' => [],
            ],
        ];
    }

    /**
     * @param array $check
     * @param array $data
     * @dataProvider checkoutPrepareProvider
     */
    public function testCheckoutPrepare(array $checkField, array $data)
    {
        $invoice = new CheckoutPrepareRules($data);

        $this->assertEquals($checkField, array_keys($invoice->getRules()));
    }
}
