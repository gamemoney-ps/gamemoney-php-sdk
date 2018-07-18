<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use Gamemoney\Request\Request;


class RequestTest extends TestCase {
    public function testConstuctor() {
        $request = new Request('/test', ['data' => 1]);
        $this->assertEquals($request->getAction(), '/test');
        $this->assertEquals($request->getData(), ['data' => 1]);
    }
}
