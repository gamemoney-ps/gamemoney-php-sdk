<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use Gamemoney\Request\Request;


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
}
