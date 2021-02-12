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
    const PROJECT = 1;

    const HMAC_KEY = 'test';

    const PRIVATE_KEY = '123';

    const PRIVATE_KEY_PASSWORD = '123';

    public function testSend()
    {
        $mockRequest = $this->getRequestMock();

        $data = ['data' => ['test' => 1], 'rand' => 'test'];

        $mockRequest
            ->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn($data);

        $mockRequest
            ->expects($this->once())
            ->method('setField')
            ->withConsecutive(
                ['project', $this->getConfig()->project()]
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
            ->setMethods(['sign', 'getSignature'])
            ->getMock();
        $mockSigner
            ->expects($this->once())
            ->method('sign')
            ->willReturn($mockRequest);

        $mockSignerResolver = $this
            ->getMockBuilder(SignerResolverInterface::class)
            ->setMethods(['resolve'])
            ->getMock();

        $mockSignerResolver
            ->expects($this->once())
            ->method('resolve')
            ->willReturn($mockSigner);

        $gateway = (new Gateway($this->getConfig()))
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
            'setSenderResolver',
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
        $gateway->__construct($this->getConfig());
    }

    private function getConfig()
    {
        return new Config($this::PROJECT, $this::HMAC_KEY, $this::PRIVATE_KEY, $this::PRIVATE_KEY_PASSWORD);
    }
}
