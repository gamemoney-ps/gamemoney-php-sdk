<?php
namespace tests\Request;

use PHPUnit\Framework\TestCase;
use Gamemoney\Request\Request;
use Gamemoney\Request\RequestInterface;


class RequestTest extends TestCase
{
    public function testConstructor()
    {
        $request = new Request('/test', ['data' => 1, 'rand' => 'test']);
        $this->assertEquals($request->getAction(), '/test');
        $this->assertEquals($request->getData(), ['data' => 1, 'rand' => 'test']);
    }

    public function testEmptyRandConstructor()
    {
        $request = new Request('/test', ['data' => 1]);
        $data = $request->getData();
        $this->assertArrayHasKey('rand', $data);
        $this->assertTrue(is_string($data['rand']));
        $this->assertGreaterThanOrEqual(20, strlen($data['rand']));
    }

    public function testSetData()
    {
        $request = new Request('/test');
        $this->isInstanceOf(
            $request->setData(['data' => 1, 'rand' => 'test']),
            RequestInterface::class
        );
        $this->assertEquals($request->getData(), ['data' => 1, 'rand' => 'test']);
    }

    public function testField()
    {
        $request = new Request('/test');
        $this->isInstanceOf(
            $request->setField('data', 1),
            RequestInterface::class
        );
        $this->assertEquals($request->getField('data'), 1);
    }
}
