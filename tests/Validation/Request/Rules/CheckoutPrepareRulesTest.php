<?php

namespace tests\Validation\Request\Rules;

use Gamemoney\Validation\Request\Rules\CheckoutPrepareRules;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CheckoutPrepareRulesTest extends TestCase
{
    public static function checkoutPrepareProvider(): array
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

    #[DataProvider('checkoutPrepareProvider')]
    public function testCheckoutPrepare(array $checkField, array $data): void
    {
        $invoice = new CheckoutPrepareRules($data);

        $this->assertEquals($checkField, array_keys($invoice->getRules()));
    }
}
