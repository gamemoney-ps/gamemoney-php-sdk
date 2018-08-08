<?php
namespace tests;

use Gamemoney\Exception\ResponseValidationException;
use Gamemoney\Sign\SignatureVerifierInterface;
use Gamemoney\Validation\Response\ResponseValidator;
use PHPUnit\Framework\TestCase;

class ResponseValidatorTest extends TestCase
{

    public function successValidateProvider()
    {
        return [
            [
                'response' => [],
                'request' => []
            ],
            [
                'response' => ['rand' => 'test', 'invoice' => 1, 'signature' => 'test signature'],
                'request' => ['rand' => 'test']
            ],
            [
                'response' => ['rand' => 'test', 'invoice' => 1, 'signature' => 'test signature'],
                'request' => []
            ],
        ];
    }
    /**
     * @param $response
     * @param $request
     * @dataProvider successValidateProvider
     */
    public function testSuccessValidate($response, $request)
    {
        $verifierMock = $this->createPartialMock(SignatureVerifierInterface::class, ['verify']);
        $verifierMock
            ->expects($this->once())
            ->method('verify')
            ->with($response)
            ->willReturn(true);

        $validator = new ResponseValidator($verifierMock);

        $this->assertNull($validator->validate($response, $request));
    }


    public function failValidateProvider()
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
     * @param $response
     * @param $request
     * @param boolean $verified
     * @dataProvider failValidateProvider
     */
    public function testFailValidate($response, $request, $verified)
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