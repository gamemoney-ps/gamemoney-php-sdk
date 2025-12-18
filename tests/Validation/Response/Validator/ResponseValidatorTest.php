<?php

namespace tests\Validation\Response\Validator;

use Gamemoney\Exception\ResponseValidationException;
use Gamemoney\Sign\SignatureVerifierInterface;
use Gamemoney\Validation\Response\Validator\ResponseValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ResponseValidatorTest extends TestCase
{
    public static function successValidateProvider(): array
    {
        return [
            [
                'response' => [],
                'request' => [],
            ],
            [
                'response' => ['rand' => 'test', 'invoice' => 1, 'signature' => 'test signature'],
                'request' => ['rand' => 'test'],
            ],
            [
                'response' => ['rand' => 'test', 'invoice' => 1, 'signature' => 'test signature'],
                'request' => [],
            ],
        ];
    }

    #[DataProvider('successValidateProvider')]
    public function testSuccessValidate(array $response, array $request): void
    {
        $verifierMock = $this->createPartialMock(SignatureVerifierInterface::class, ['verify']);
        $verifierMock
            ->expects($this->once())
            ->method('verify')
            ->with($response)
            ->willReturn(true);

        $validator = new ResponseValidator($verifierMock);
        $validator->validate($response, $request);
    }

    public static function failValidateProvider(): array
    {
        return [
            [
                'response' => ['rand' => 'wrong rand', 'invoice' => 1, 'signature' => 'test signature'],
                'request' => ['rand' => 'test'],
                'verified' => true,
            ],
            [
                'response' => ['rand' => 'test', 'invoice' => 1, 'signature' => 'test signature'],
                'request' => ['rand' => 'test'],
                'verified' => false,
            ],
        ];
    }

    #[DataProvider('failValidateProvider')]
    public function testFailValidate(array $response, array $request, bool $verified): void
    {
        $verifierMock = $this->createPartialMock(SignatureVerifierInterface::class, ['verify']);
        $verifierMock
            ->expects($this->once())
            ->method('verify')
            ->with($response)
            ->willReturn($verified);

        $validator = new ResponseValidator($verifierMock);
        $this->expectException(ResponseValidationException::class);
        $validator->validate($response, $request);
    }
}
