<?php

namespace tests\Validation\Response\Validator;

use Gamemoney\Exception\ResponseValidationException;
use Gamemoney\Sign\SignatureVerifierInterface;
use Gamemoney\Validation\Response\Validator\ResponseValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ResponseValidatorTest extends TestCase
{
    /**
     * @return array
     */
    public static function successValidateProvider()
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

    /**
     * @param array $response
     * @param array $request
     */
    #[DataProvider('successValidateProvider')]
    public function testSuccessValidate(array $response, array $request)
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

    /**
     * @return array
     */
    public static function failValidateProvider()
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

    /**
     * @param array $response
     * @param array $request
     * @param bool $verified
     */
    #[DataProvider('failValidateProvider')]
    public function testFailValidate(array $response, array $request, $verified)
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
