<?php

namespace tests\CallbackHandler;

use Gamemoney\CallbackHandler\BaseCallbackHandler;
use Gamemoney\Config;
use Gamemoney\Sign\SignatureVerifierInterface;
use Gamemoney\Sign\SignerResolverInterface;
use PHPUnit\Framework\TestCase;

class BaseCallbackHandlerTest extends TestCase
{
    const PROJECT = 1;

    const HMAC_KEY = 'test';

    const CERTIFICATE = 'test_certificate';

    const PRIVATE_KEY = '123';

    public function testConstruct(): void
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

    public function testCheck(): void
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

    public function testSuccessAnswer(): void
    {
        $result = '{"success":"true"}';

        $handler = new BaseCallbackHandler($this->getConfig());
        $this->assertEquals($result, $handler->successAnswer());
    }

    public function testErrorAnswer(): void
    {
        $result = '{"success":"error"}';

        $handler = new BaseCallbackHandler($this->getConfig());
        $this->assertEquals($result, $handler->errorAnswer());
    }

    public function testErrorWithMessageAnswer(): void
    {
        $result = '{"success":"error","error":"message"}';

        $handler = new BaseCallbackHandler($this->getConfig());
        $this->assertEquals($result, $handler->errorAnswer('message'));
    }

    private function getConfig(): Config
    {
        return new Config(
            self::PROJECT,
            self::HMAC_KEY,
            self::CERTIFICATE,
            self::PRIVATE_KEY,
        );
    }
}
