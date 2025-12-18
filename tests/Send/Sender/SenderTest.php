<?php

namespace tests\Send\Sender;

use Gamemoney\Send\Sender\Sender;
use PHPUnit\Framework\TestCase;
use Gamemoney\Send\SenderInterface;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class SenderTest extends TestCase
{
    const URL = 'url';

    public function testInterface(): void
    {
        $sender = new Sender($this::URL, []);
        $this->assertInstanceOf(SenderInterface::class, $sender);
    }

    public function testSend(): void
    {
        $mockRequest = $this->getRequestMock();

        $mock = new MockHandler([
            new Response(200, [], '{"1":"2"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $sender = new Sender($this::URL, ['handler' => $handler]);

        $response = $sender->send($mockRequest);
        $this->assertEquals($response, ['1' => '2']);
    }

    public function testSendException(): void
    {
        $this->expectException(RequestException::class);
        $mockRequest = $this->getRequestMock();

        $mock = new MockHandler([
            new Response(404, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $sender = new Sender($this::URL, ['handler' => $handler]);
        $sender->send($mockRequest);
    }

    private function getRequestMock(): RequestInterface
    {
        $mockRequest = $this
            ->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getData', 'getAction', 'setData', 'getField', 'setField'])
            ->getMock();

        $mockRequest
            ->method('getData')
            ->willReturn(['data' => ['test' => 1]]);

        $mockRequest
            ->method('getAction')
            ->willReturn('testUrl');

        return $mockRequest;
    }
}
