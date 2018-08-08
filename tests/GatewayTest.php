<?php
namespace tests;

use Gamemoney\Sign\SignerInterface;
use Gamemoney\Sign\SignerResolverInterface;
use Gamemoney\Validation\Request\Rules\DefaultRules;
use Gamemoney\Validation\Request\RulesInterface;
use Gamemoney\Validation\Response\ResponseValidatorInterface;
use PHPUnit\Framework\TestCase;
use Gamemoney\Gateway;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\SenderInterface;
use Gamemoney\Exception\ConfigException;
use Gamemoney\Validation\Request\RequestValidatorInterface;
use Gamemoney\Validation\Request\RulesResolverInterface;

class GatewayTest extends TestCase
{
    private $config;

    protected function setUp()
    {
        $this->config = [
            'privateKey' => "123",
            'hmacKey' => 'test',
            'project' => 1,
            'apiPublicKey' => '123'
        ];
    }

    public function configDataProvider()
    {
        return [
            [
                []
            ],
            [
                [
                    'project' => 1,
                    'hmacKey' => 'test',
                ]
            ],
            [
                [
                    'project' => 1,
                    'apiPublicKey' => 'testPublicKey'
                ]
            ],
            [
                [
                    'hmacKey' => 'test',
                    'apiPublicKey' => 'testPublicKey'
                ]
            ],
        ];
    }

    /**
     * @dataProvider configDataProvider
     * @param $config
     */
    public function testConstructConfigWrong($config)
    {
        $this->expectException(ConfigException::class);
        $gateway = new Gateway($config);

    }

    public function successConfigDataProvider()
    {
        return [
            [
                [
                    'project' => 1,
                    'hmacKey' => 'test',
                    'apiPublicKey' => 'testPublicKey'
                ]
            ],
            [
                [
                    'project' => 1,
                    'hmacKey' => 'test',
                    'privateKey' => 'test',
                    'apiPublicKey' => 'testPublicKey'
                ]
            ],
        ];
    }

    /**
     * @dataProvider successConfigDataProvider
     * @param $config
     */
    public function testConstructConfigSuccess($config)
    {
        $gateway = new Gateway($config);
        $this->assertInstanceOf(Gateway::class, $gateway);
    }


    public function testSend()
    {
        $mockRequest = $this->getRequestMock();

        $data = ['data' => ['test' => 1]];
        $signature = 'testSignature';

        $mockRequest
            ->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn($data);

        $mockRequest
            ->expects($this->exactly(2))
            ->method('setField')
            ->withConsecutive(
                ['project', $this->config['project']],
                ['signature', $signature]
            );

        $mockRules = $this
            ->getMockBuilder(RulesInterface::class)
            ->setMethods(['getRules'])
            ->getMock();

        $rules = ['some rules'];
        $mockRules
            ->expects($this->once())
            ->method('getRules')
            ->willReturn($rules);

        $mockRulesResolver = $this
            ->getMockBuilder(RulesResolverInterface::class)
            ->setMethods(['resolve'])
            ->getMock();

        $mockRulesResolver
            ->expects($this->once())
            ->method('resolve')
            ->willReturn($mockRules);

        $mockSender = $this
            ->getMockBuilder(SenderInterface::class)
            ->setMethods(['send'])
            ->getMock();

        $senderResult = ['success' => 'true'];
        $mockSender
            ->expects($this->once())
            ->method('send')
            ->with($mockRequest)
            ->willReturn($senderResult);

        $mockRequestValidator = $this
            ->getMockBuilder(RequestValidatorInterface::class)
            ->setMethods(['validate'])
            ->getMock();

        $mockRequestValidator
            ->expects($this->once())
            ->method('validate')
            ->with($rules, $data)
            ->willReturn(null);

        $mockResponseValidator = $this
            ->getMockBuilder(ResponseValidatorInterface::class)
            ->setMethods(['validate'])
            ->getMock();

        $mockResponseValidator
            ->expects($this->once())
            ->method('validate')
            ->with($senderResult, $data)
            ->willReturn(null);

        $mockSigner = $this
            ->getMockBuilder(SignerInterface::class)
            ->setMethods(['getSignature'])
            ->getMock();
        $mockSigner
            ->expects($this->once())
            ->method('getSignature')
            ->willReturn($signature);

        $mockSignerResolver = $this
            ->getMockBuilder(SignerResolverInterface::class)
            ->setMethods(['resolve'])
            ->getMock();

        $mockSignerResolver
            ->expects($this->once())
            ->method('resolve')
            ->willReturn($mockSigner);

        $gateway = (new Gateway($this->config))
            ->setSender($mockSender)
            ->setRequestValidator($mockRequestValidator)
            ->setResponseValidator($mockResponseValidator)
            ->setSignerResolver($mockSignerResolver)
            ->setRulesResolver($mockRulesResolver);

        $response = $gateway->send($mockRequest);
        $this->assertEquals($senderResult, $response);
    }

    private function getRequestMock()
    {
        $mockRequest = $this
            ->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['getData', 'getAction', 'setData', 'setAction', 'getField', 'setField'])
            ->getMock();

        return $mockRequest;
    }

    public function testConstuctMethod()
    {
        $gateway = $this->createPartialMock(Gateway::class, [
            'setRequestValidator',
            'setSignerResolver',
            'setResponseValidator',
            'setRulesResolver',
            'setSender'
        ]);

        $gateway
            ->expects($this->once())
            ->method('setRequestValidator')
            ->with($this->isInstanceOf(RequestValidatorInterface::class))
            ->will($this->returnSelf());
        $gateway
            ->expects($this->once())
            ->method('setResponseValidator')
            ->with($this->isInstanceOf(ResponseValidatorInterface::class))
            ->will($this->returnSelf());
        $gateway
            ->expects($this->once())
            ->method('setRulesResolver')
            ->with($this->isInstanceOf(RulesResolverInterface::class))
            ->will($this->returnSelf());
        $gateway
            ->expects($this->once())
            ->method('setSender')
            ->with($this->isInstanceOf(SenderInterface::class))
            ->will($this->returnSelf());
        $gateway
            ->expects($this->once())
            ->method('setSignerResolver')
            ->with($this->isInstanceOf(SignerResolverInterface::class))
            ->will($this->returnSelf());
        $gateway->__construct($this->config);
    }
}