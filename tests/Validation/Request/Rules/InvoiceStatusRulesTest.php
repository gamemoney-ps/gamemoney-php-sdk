<?php
namespace tests\Validation\Request\Rules;

use Gamemoney\Validation\Request\Rules\InvoiceStatusRules;
use PHPUnit\Framework\TestCase;

class InvoiceStatusRulesTest extends TestCase
{
    /**
    * @return array
    */
    public function invoiceStatusProvider()
    {
        return [
            [
                'checkField' => ['project', 'rand', 'invoice'],
                'data' => [
                    'project' => 123456,
                    'rand' => '56f97b6c07d66cde3d20',
                    'invoice' => 1
                ]
            ],
            [
                'checkField' => ['project', 'rand', 'invoice'],
                'data' => [
                    'project' => 123456,
                    'rand' => '56f97b6c07d66cde3d20',
                    'invoice' => 1,
                    'project_invoice' => 'test'
                ]
            ],
            [
                'checkField' => ['project', 'rand', 'project_invoice'],
                'data' => [
                    'project' => 123456,
                    'rand' => '56f97b6c07d66cde3d20',
                    'project_invoice' => 'test'
                ]
            ],
        ];
    }

    /**
     * @param array $check
     * @param array $data
     * @dataProvider invoiceStatusProvider
     */
    public function testInvoiceStatus(array $checkField, array $data)
    {
        $invoice = new InvoiceStatusRules($data);

        $this->assertEquals($checkField, array_keys($invoice->getRules()));

        foreach ($checkField as $item) {
            $this->assertArrayHasKey($item, $invoice->getRules());
        }
    }
}
