<?php

namespace tests\Request;

use PHPUnit\Framework\TestCase;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Request\RequestFactory;

class RequestFactoryTest extends TestCase
{
    public function methodDataProvider()
    {
        return [
            [
                'createInvoice',
                [
                    'invoice' => 1
                ],
                RequestInterface::INVOICE_CREATE_ACTION,
                [
                    'invoice' => 1
                ],
            ]
        ];
    }

    /**
     * @dataProvider methodDataProvider
     */
    public function testMethods($method, $arg, $action, $expectedData)
    {
        $request = call_user_func_array([RequestFactory::class, $method], [$arg]);
        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertEquals($request->getAction(), $action);
        $requestData = $request->getData();
        unset($requestData['rand']);
        $this->assertEquals($requestData, $expectedData);
    }
}