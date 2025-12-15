<?php

namespace tests\CallbackHandler;

use Gamemoney\CallbackHandler\TransferCallbackHandler;
use Gamemoney\Config;
use Gamemoney\Exception\ConfigException;
use Gamemoney\Sign\SignerInterface;
use Gamemoney\Sign\SignerResolverInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TransferCallbackHandlerTest extends TestCase
{
    const PROJECT = 1;

    const HMAC_KEY = 'test';

    const PRIVATE_KEY = '123';

    public function testSuccessAnswerInvoiceNull()
    {
        $this->expectException(ConfigException::class);

        $handler = new TransferCallbackHandler($this->getConfig());
        $handler->successAnswer();
    }

    public function testSuccessAnswer()
    {
        $invoiceNumber = 1;
        $sign = 'testSign';

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
            ->willReturn($sign);

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

    /**
     * @return array
     */
    public static function errorDataProvider()
    {
        return [
            [
                'error' => null,
                'output' => '{"state":"error","signature":"testSign"}',
            ],
            [
                'error' => 'message',
                'output' => '{"state":"error","error":"message","signature":"testSign"}',
            ],
        ];
    }

    /**
     * @param string|null $error
     * @param string $output
     */
    #[DataProvider('errorDataProvider')]
    public function testErrorAnswer($error, $output)
    {
        $sign = 'testSign';

        $mockSigner = $this->createPartialMock(SignerInterface::class, ['sign', 'getSignature']);
        $mockSigner
            ->expects($this->once())
            ->method('getSignature')
            ->willReturn($sign);

        $mockResolver = $this->createPartialMock(SignerResolverInterface::class, ['resolve']);
        $mockResolver
            ->expects($this->once())
            ->method('resolve')
            ->willReturn($mockSigner);

        $handler = new TransferCallbackHandler($this->getConfig());
        $handler->setSignerResolver($mockResolver);

        $this->assertEquals($output, $handler->errorAnswer($error));
    }

    private function getConfig()
    {
        return new Config($this::PROJECT, $this::HMAC_KEY, $this::PRIVATE_KEY);
    }
}
