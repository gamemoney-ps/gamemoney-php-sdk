<?php

namespace tests\Request;

use Gamemoney\Request\Request;
use Gamemoney\Request\RequestInterface;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testConstructor(): void
    {
        $request = new Request('/test', ['data' => 1, 'rand' => 'test']);
        $this->assertEquals($request->getAction(), '/test');
        $this->assertEquals($request->getData(), ['data' => 1, 'rand' => 'test']);
    }

    public function testSetData(): void
    {
        $request = new Request('/test');
        $this->assertInstanceOf(
            RequestInterface::class,
            $request->setData(['data' => 1, 'rand' => 'test']),
        );
        $this->assertEquals($request->getData(), ['data' => 1, 'rand' => 'test']);
    }

    public function testField(): void
    {
        $request = new Request('/test');
        $this->assertInstanceOf(
            RequestInterface::class,
            $request->setField('data', 1),
        );
        $this->assertEquals($request->getField('data'), 1);
    }
}
