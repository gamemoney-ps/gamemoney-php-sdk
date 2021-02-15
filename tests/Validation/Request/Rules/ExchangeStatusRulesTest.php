<?php

namespace tests\Validation\Request\Rules;

use Gamemoney\Validation\Request\Rules\ExchangeStatusRules;
use PHPUnit\Framework\TestCase;

class ExchangeStatusRulesTest extends TestCase
{
    /**
     * @return array
     */
    public function exchangeStatusProvider()
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

    /**
     * @param array $check
     * @param array $data
     * @dataProvider exchangeStatusProvider
     */
    public function testExchangeStatus(array $checkField, array $data)
    {
        $exchange = new ExchangeStatusRules($data);

        $this->assertEquals($checkField, array_keys($exchange->getRules()));
    }
}
