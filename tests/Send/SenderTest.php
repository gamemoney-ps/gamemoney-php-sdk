<?php
namespace tests\Send;

use PHPUnit\Framework\TestCase;
use Gamemoney\Send\Sender;
use Gamemoney\Send\SenderInterface;
use Gamemoney\Sign\SignerResolverInterface;
use Gamemoney\Sign\SignerInterface;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class SenderTest extends TestCase
{
    private $url;

    protected function setUp()
    {
        $this->url = 'url';
    }
    public function testInterface()
    {
        $mockResolver = $this->createMock(SignerResolverInterface::class);
        $sender = new Sender('url', $mockResolver, []);
        $this->assertInstanceOf(SenderInterface::class, $sender);
    }

    public function testSend()
    {
        $mockRequest = $this->getRequestMock();

        $mock = new MockHandler([
            new Response(200, [], '{"1":"2"}'),
        ]);

        $handler = HandlerStack::create($mock);
        $sender = $this->getSenderMock($handler);

        $response = $sender->send($mockRequest);
        $this->assertTrue(is_array($response));
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
        $sender = $this->getSenderMock($handler);
        $sender->send($mockRequest);
    }

    private function getSenderMock($handler)
    {
        $mockSigner = $this
            ->getMockBuilder(SignerInterface::class)
            ->setMethods(['getSignature', 'arrayToString'])
            ->getMock();
        $mockSigner
            ->expects($this->once())
            ->method('getSignature')
            ->willReturn('signature');

        $mockResolver = $this
            ->getMockBuilder(SignerResolverInterface::class)
            ->setMethods(['resolve'])
            ->getMock();

        $mockResolver
            ->method('resolve')
            ->willReturn($mockSigner);

        $sender = new Sender($this->url, $mockResolver, ['handler' => $handler]);

        return $sender;
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