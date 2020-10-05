<?php
namespace tests;

use Gamemoney\Config;
use Gamemoney\Send\SenderResolverInterface;
use Gamemoney\Sign\SignerInterface;
use Gamemoney\Sign\SignerResolverInterface;
use Gamemoney\Validation\Request\RulesInterface;
use Gamemoney\Validation\Response\ResponseValidatorInterface;
use Gamemoney\Validation\Response\ResponseValidatorResolverInterface;
use PHPUnit\Framework\TestCase;
use Gamemoney\Gateway;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\SenderInterface;
use Gamemoney\Validation\Request\RequestValidatorInterface;
use Gamemoney\Validation\Request\RulesResolverInterface;

class GatewayTest extends TestCase
{
    /** @var Config */
    private $config;

    protected function setUp()
    {
        $project = 1;
        $hmacKey = 'test';
        $privateKey = '123';
        $privateKeyPassword = '123';

        $this->config = new Config($project, $hmacKey, $privateKey, $privateKeyPassword);
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
                ['project', $this->config->project()],
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
            ->willReturn($senderResult);

        $mockSenderResolver = $this
            ->getMockBuilder(SenderResolverInterface::class)
            ->setMethods(['resolve'])
            ->getMock();

        $mockSenderResolver
            ->expects($this->once())
            ->method('resolve')
            ->willReturn($mockSender);

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

        $mockResponseValidatorResolver = $this
            ->getMockBuilder(ResponseValidatorResolverInterface::class)
            ->setMethods(['resolve'])
            ->getMock();

        $mockResponseValidatorResolver
            ->expects($this->once())
            ->method('resolve')
            ->willReturn($mockResponseValidator);

        $mockSigner = $this
            ->getMockBuilder(SignerInterface::class)
            ->setMethods(['sign'])
            ->getMock();
        $mockSigner
            ->expects($this->once())
            ->method('sign')
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
            ->setSenderResolver($mockSenderResolver)
            ->setRequestValidator($mockRequestValidator)
            ->setResponseValidatorResolver($mockResponseValidatorResolver)
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

    public function testConstructMethod()
    {
        $gateway = $this->createPartialMock(Gateway::class, [
            'setRequestValidator',
            'setSignerResolver',
            'setResponseValidatorResolver',
            'setRulesResolver',
            'setSenderResolver'
        ]);

        $gateway
            ->expects($this->once())
            ->method('setRequestValidator')
            ->with($this->isInstanceOf(RequestValidatorInterface::class))
            ->will($this->returnSelf());
        $gateway
            ->expects($this->once())
            ->method('setResponseValidatorResolver')
            ->with($this->isInstanceOf(ResponseValidatorResolverInterface::class))
            ->will($this->returnSelf());
        $gateway
            ->expects($this->once())
            ->method('setRulesResolver')
            ->with($this->isInstanceOf(RulesResolverInterface::class))
            ->will($this->returnSelf());
        $gateway
            ->expects($this->once())
            ->method('setSenderResolver')
            ->with($this->isInstanceOf(SenderResolverInterface::class))
            ->will($this->returnSelf());
        $gateway
            ->expects($this->once())
            ->method('setSignerResolver')
            ->with($this->isInstanceOf(SignerResolverInterface::class))
            ->will($this->returnSelf());
        $gateway->__construct($this->config);
    }
}
