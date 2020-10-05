<?php

namespace tests\Send\Sender;

use Gamemoney\Exception\RequestException;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\Sender\SecureSender;
use Gamemoney\Send\Sender\Sender;
use Gamemoney\Send\SenderInterface;
use PHPUnit\Framework\TestCase;

class SecureSenderTest extends TestCase
{
    /** @var string */
    private $url;

    protected function setUp()
    {
        $this->url = 'url';
    }

    public function testInterface()
    {
        $sender = new Sender('url', []);
        $this->assertInstanceOf(SenderInterface::class, $sender);
    }

    public function testSend()
    {
        $mockRequest = $this->getRequestMock();

        $sender = new SecureSender($this->url);

        $response = $sender->send($mockRequest);
        $this->assertInternalType('array', $response);
        $this->assertEquals($response, ['1'=>'2']);
    }

    public function testSendException()
    {
        $this->expectException(RequestException::class);
        $mockRequest = $this->getRequestMock();

        $sender = new SecureSender($this->url);
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

        return $mockRequest;
    }
}
