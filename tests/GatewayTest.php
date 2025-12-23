<?php

namespace tests;

use Gamemoney\Config;
use Gamemoney\Send\Sender;
use Gamemoney\Send\SenderInterface;
use Gamemoney\Sign\SignerInterface;
use Gamemoney\Sign\SignerResolverInterface;
use Gamemoney\Validation\Request\RulesInterface;
use Gamemoney\Validation\Response\ResponseValidator;
use Gamemoney\Validation\Response\ResponseValidatorInterface;
use PHPUnit\Framework\TestCase;
use Gamemoney\Gateway;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Validation\Request\RequestValidatorInterface;
use Gamemoney\Validation\Request\RulesResolverInterface;

class GatewayTest extends TestCase
{
    public function testSend(): void
    {
        $mockRequest = $this
            ->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getData', 'getAction', 'setData', 'getField', 'setField'])
            ->getMock();

        $data = ['data' => ['test' => 1], 'rand' => 'test'];

        $mockRequest
            ->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn($data);

        $mockRequest
            ->expects($this->once())
            ->method('setField')
            ->with('project', $this->getConfig()->getProject());

        $mockRules = $this
            ->getMockBuilder(RulesInterface::class)
            ->onlyMethods(['getRules'])
            ->getMock();

        $rules = ['some rules'];
        $mockRules
            ->expects($this->once())
            ->method('getRules')
            ->willReturn($rules);

        $mockRulesResolver = $this
            ->getMockBuilder(RulesResolverInterface::class)
            ->onlyMethods(['resolve'])
            ->getMock();

        $mockRulesResolver
            ->expects($this->once())
            ->method('resolve')
            ->willReturn($mockRules);

        $mockSender = $this
            ->getMockBuilder(SenderInterface::class)
            ->onlyMethods(['send'])
            ->getMock();

        $senderResult = ['success' => 'true'];
        $mockSender
            ->expects($this->once())
            ->method('send')
            ->willReturn($senderResult);

        $mockRequestValidator = $this
            ->getMockBuilder(RequestValidatorInterface::class)
            ->onlyMethods(['validate'])
            ->getMock();

        $mockRequestValidator
            ->expects($this->once())
            ->method('validate')
            ->with($rules, $data);

        $mockResponseValidator = $this
            ->getMockBuilder(ResponseValidatorInterface::class)
            ->onlyMethods(['validate'])
            ->getMock();

        $mockResponseValidator
            ->expects($this->once())
            ->method('validate')
            ->with($senderResult, $data);

        $mockSigner = $this
            ->getMockBuilder(SignerInterface::class)
            ->onlyMethods(['sign', 'getSignature'])
            ->getMock();
        $mockSigner
            ->expects($this->once())
            ->method('sign')
            ->willReturn($mockRequest);

        $mockSignerResolver = $this
            ->getMockBuilder(SignerResolverInterface::class)
            ->onlyMethods(['resolve'])
            ->getMock();

        $mockSignerResolver
            ->expects($this->once())
            ->method('resolve')
            ->willReturn($mockSigner);

        $gateway = (new Gateway($this->getConfig()))
            ->setSender($mockSender)
            ->setRequestValidator($mockRequestValidator)
            ->setResponseValidator($mockResponseValidator)
            ->setSignerResolver($mockSignerResolver)
            ->setRulesResolver($mockRulesResolver);

        $response = $gateway->send($mockRequest);
        $this->assertEquals($senderResult, $response);
    }

    public function testConstructMethod(): void
    {
        $gateway = $this->createPartialMock(Gateway::class, [
            'setRequestValidator',
            'setSignerResolver',
            'setResponseValidator',
            'setRulesResolver',
            'setSender',
        ]);

        $gateway
            ->expects($this->once())
            ->method('setRequestValidator')
            ->with($this->isInstanceOf(RequestValidatorInterface::class))
            ->willReturnSelf();
        $gateway
            ->expects($this->once())
            ->method('setResponseValidator')
            ->with($this->isInstanceOf(ResponseValidator::class))
            ->willReturnSelf();
        $gateway
            ->expects($this->once())
            ->method('setRulesResolver')
            ->with($this->isInstanceOf(RulesResolverInterface::class))
            ->willReturnSelf();
        $gateway
            ->expects($this->once())
            ->method('setSender')
            ->with($this->isInstanceOf(Sender::class))
            ->willReturnSelf();
        $gateway
            ->expects($this->once())
            ->method('setSignerResolver')
            ->with($this->isInstanceOf(SignerResolverInterface::class))
            ->willReturnSelf();
        $gateway->__construct($this->getConfig());
    }

    private function getConfig(): Config
    {
        return new Config(
            'test_api_url',
            123,
            'test_certificate',
            'test_hmac',
            'test_private_key',
            'test_public_key',
        );
    }
}
