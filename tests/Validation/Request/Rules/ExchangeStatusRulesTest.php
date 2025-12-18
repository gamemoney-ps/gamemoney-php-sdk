<?php

namespace tests\Validation\Request\Rules;

use Gamemoney\Validation\Request\Rules\ExchangeStatusRules;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ExchangeStatusRulesTest extends TestCase
{
    public static function exchangeStatusProvider(): array
    {
        return [
            [
                'checkField' => ['project', 'rand', 'id'],
                'data' => [
                    'project' => 123456,
                    'rand' => '56f97b6c07d66cde3d20',
                    'id' => 1,
                ],
            ],
            [
                'checkField' => ['project', 'rand', 'id'],
                'data' => [
                    'project' => 123456,
                    'rand' => '56f97b6c07d66cde3d20',
                    'id' => 1,
                    'externalId' => 'test',
                ],
            ],
            [
                'checkField' => ['project', 'rand', 'externalId'],
                'data' => [
                    'project' => 123456,
                    'rand' => '56f97b6c07d66cde3d20',
                    'externalId' => 'test',
                ],
            ],
        ];
    }

    #[DataProvider('exchangeStatusProvider')]
    public function testExchangeStatus(array $checkField, array $data): void
    {
        $exchange = new ExchangeStatusRules($data);

        $this->assertEquals($checkField, array_keys($exchange->getRules()));
    }
}
