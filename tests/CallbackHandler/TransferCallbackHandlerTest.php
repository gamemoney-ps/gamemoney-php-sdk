<?php

namespace tests\CallbackHandler;

use Gamemoney\CallbackHandler\TransferCallbackHandler;
use Gamemoney\Config;
use Gamemoney\Exception\ConfigException;
use Gamemoney\Sign\SignerInterface;
use Gamemoney\Sign\SignerResolverInterface;
use PHPUnit\Framework\TestCase;

class TransferCallbackHandlerTest extends TestCase
{
    public function testSuccessAnswerInvoiceNull(): void
    {
        $this->expectException(ConfigException::class);

        $handler = new TransferCallbackHandler($this->getConfig());
        $handler->setInvoiceNumber(null);
        $handler->successAnswer();
    }

    public function testSuccessAnswer(): void
    {
        $invoiceNumber = 1;

        $result = '{"state":"success","invoice":1,"signature":"testSign"}';
        $data = [
            'state' => 'success',
            'invoice' => $invoiceNumber,
        ];

        $mockSigner = $this->createPartialMock(SignerInterface::class, ['sign', 'getSignature']);
        $mockSigner
            ->expects($this->once())
            ->method('getSignature')
            ->with($data)
            ->willReturn('testSign');

        $mockResolver = $this->createPartialMock(SignerResolverInterface::class, ['resolve']);
        $mockResolver
            ->expects($this->once())
            ->method('resolve')
            ->willReturn($mockSigner);

        $handler = new TransferCallbackHandler($this->getConfig());
        $handler->setInvoiceNumber($invoiceNumber);
        $handler->setSignerResolver($mockResolver);
        $this->assertEquals($result, $handler->successAnswer());
    }

    public function testErrorAnswer(): void
    {
        $handler = new TransferCallbackHandler($this->getConfig());
        $handler->setSignerResolver($this->getMock());

        $expect = '{"state":"error","signature":"testSign"}';

        $this->assertEquals($expect, $handler->errorAnswer());
    }

    public function testErrorWithMessageAnswer(): void
    {
        $handler = new TransferCallbackHandler($this->getConfig());
        $handler->setSignerResolver($this->getMock());

        $expect = '{"state":"error","error":"message","signature":"testSign"}';

        $this->assertEquals($expect, $handler->errorAnswer('message'));
    }

    private function getMock(): SignerResolverInterface
    {
        $mockSigner = $this->createPartialMock(SignerInterface::class, ['sign', 'getSignature']);
        $mockSigner
            ->expects($this->once())
            ->method('getSignature')
            ->willReturn('testSign');

        $mockResolver = $this->createPartialMock(SignerResolverInterface::class, ['resolve']);
        $mockResolver
            ->expects($this->once())
            ->method('resolve')
            ->willReturn($mockSigner);

        return $mockResolver;
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
