<?php

namespace tests\CallbackHandler;

use Gamemoney\CallbackHandler\BaseCallbackHandler;
use Gamemoney\Config;
use Gamemoney\Sign\SignatureVerifierInterface;
use Gamemoney\Sign\SignerResolverInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class BaseCallbackHandlerTest extends TestCase
{
    const PROJECT = 1;

    const HMAC_KEY = 'test';

    const PRIVATE_KEY = '123';

    public function testConstruct()
    {
        $handler = $this->createPartialMock(BaseCallbackHandler::class, [
            'setSignatureVerifier',
            'setSignerResolver',
        ]);

        $handler
            ->expects($this->once())
            ->method('setSignatureVerifier')
            ->with($this->isInstanceOf(SignatureVerifierInterface::class))
            ->willReturnSelf();

        $handler
            ->expects($this->once())
            ->method('setSignerResolver')
            ->with($this->isInstanceOf(SignerResolverInterface::class))
            ->willReturnSelf();

        $handler->__construct($this->getConfig());
    }

    public function testCheck()
    {
        $result = true;
        $data = [];

        $mockVerifier = $this->createPartialMock(SignatureVerifierInterface::class, [
            'verify',
        ]);

        $mockVerifier
            ->expects($this->once())
            ->method('verify')
            ->with($data)
            ->willReturn($result);

        $handler = new BaseCallbackHandler($this->getConfig());
        $handler->setSignatureVerifier($mockVerifier);
        $this->assertEquals($result, $handler->check($data));
    }

    public function testSuccessAnswer()
    {
        $result = '{"success":"true"}';

        $handler = new BaseCallbackHandler($this->getConfig());
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
                'output' => '{"success":"error"}',
            ],
            [
                'error' => 'message',
                'output' => '{"success":"error","error":"message"}',
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
        $handler = new BaseCallbackHandler($this->getConfig());
        $this->assertEquals($output, $handler->errorAnswer($error));
    }

    private function getConfig()
    {
        return new Config($this::PROJECT, $this::HMAC_KEY, $this::PRIVATE_KEY);
    }
}
