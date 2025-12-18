<?php

namespace tests\Validation\Request\Rules;

use Gamemoney\Validation\Request\Rules\InvoiceStatusRules;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class InvoiceStatusRulesTest extends TestCase
{
    public static function invoiceStatusProvider(): array
    {
        return [
            [
                'checkField' => ['project', 'rand', 'invoice'],
                'data' => [
                    'project' => 123456,
                    'rand' => '56f97b6c07d66cde3d20',
                    'invoice' => 1,
                ],
            ],
            [
                'checkField' => ['project', 'rand', 'invoice'],
                'data' => [
                    'project' => 123456,
                    'rand' => '56f97b6c07d66cde3d20',
                    'invoice' => 1,
                    'project_invoice' => 'test',
                ],
            ],
            [
                'checkField' => ['project', 'rand', 'project_invoice'],
                'data' => [
                    'project' => 123456,
                    'rand' => '56f97b6c07d66cde3d20',
                    'project_invoice' => 'test',
                ],
            ],
        ];
    }

    #[DataProvider('invoiceStatusProvider')]
    public function testInvoiceStatus(array $checkField, array $data): void
    {
        $invoice = new InvoiceStatusRules($data);

        $this->assertEquals($checkField, array_keys($invoice->getRules()));
    }
}
