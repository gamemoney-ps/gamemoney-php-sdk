<?php

namespace tests\Send\Sender;

use Gamemoney\Exception\RequestException;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\Sender\JsonSender;
use Gamemoney\Send\SenderInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class JsonSenderTest extends TestCase
{
    /** @var string */
    private $url;

    protected function setUp()
    {
        $this->url = 'url';
    }

    public function testInterface()
    {
        $sender = new JsonSender($this->url, []);
        $this->assertInstanceOf(SenderInterface::class, $sender);
    }

    public function testSend()
    {
        $mockRequest = $this->getRequestMock();

        $mock = new MockHandler([
            new Response(200, [], '{"1":"2"}'),
        ]);

        $handler = HandlerStack::create($mock);

        $sender = new JsonSender($this->url, ['handler' => $handler]);

        $response = $sender->send($mockRequest);
        $this->assertInternalType('array', $response);
        $this->assertEquals($response, ['1'=>'2']);
    }

    public function testSendException()
    {
        $this->expectException(RequestException::class);
        $mockRequest = $this->getRequestMock();

        $mock = new MockHandler([
            new Response(404, [], ''),
        ]);

        $handler = HandlerStack::create($mock);

        $sender = new JsonSender($this->url, ['handler' => $handler]);
        $sender->send($mockRequest);
    }

    private function getRequestMock()
    {
        $mockRequest = $this
            ->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['getData', 'getAction', 'setData', 'setAction', 'getField', 'setField'])
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
