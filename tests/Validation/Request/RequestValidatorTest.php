<?php

namespace tests\Validation\Request;

use Gamemoney\Exception\RequestValidationException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Gamemoney\Validation\Request\RequestValidator;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class RequestValidatorTest extends TestCase
{
    public static function successValidateProvider(): array
    {
        return [
            ['rules' => [], 'data' => []],
            [
                'rules' => [
                    'param1' => [new NotBlank()],
                    'param2' => [new NotBlank()],
                    'param3' => [new NotBlank()],
                ],
                'data' => [
                    'param1' => 'test',
                    'param2' => '0',
                    'param3' => 0,
                ],
            ],
            [
                'rules' => [
                    'param1' => [new Type('string'), new Length(4)],
                    'param2' => [new Type('string'), new Length(max: 3)],
                    'param3' => [new Type('string'), new Length(min: 5)],
                    'param4' => [new Type('string')],
                    'param5' => [new Length(4)],
                ],
                'data' => [
                    'param1' => 'aaaa',
                    'param2' => 'a',
                    'param3' => 'aaaaa',
                    'param4' => null,
                    'param5' => null,
                ],
            ],
            [
                'rules' => [
                    'param1' => [new Type('scalar')],
                    'param2' => [new Type('scalar')],
                    'param3' => [new Type('scalar')],
                    'param4' => [new Type('scalar')],
                ],
                'data' => [
                    'param1' => 'string',
                    'param2' => 1,
                    'param3' => false,
                    'param4' => 4.1,
                ],
            ],
            [
                'rules' => [
                    'param' => [new DateTime()],
                ],
                'data' => [
                    'param' => '2018-10-01 12:10:05',
                ],
            ],
        ];
    }

    #[DataProvider('successValidateProvider')]
    public function testSuccessValidate(array $rules, array $data): void
    {
        $validator = new RequestValidator();
        $this->assertNull($validator->validate($rules, $data));
    }

    public static function failValidateProvider(): array
    {
        return [
            [
                'rules' => [
                    'param1' => [new NotBlank()],
                    'param2' => [new NotBlank()],
                ],
                'data' => ['param1' => 'test'],
            ],
            ['rules' => ['param' => [new NotBlank()]], 'data' => ['param' => '']],
            ['rules' => ['param' => [new NotBlank()]], 'data' => ['param' => null]],
            ['rules' => ['param' => [new NotBlank()]], 'data' => ['param' => false]],
            ['rules' => ['param' => [new NotBlank()]], 'data' => []],
            [
                'rules' => [
                    'param' => [new DateTime()],
                ],
                'data' => ['param' => '2018-10-01'],
            ],
        ];
    }

    #[DataProvider('failValidateProvider')]
    public function testFailValidate(array $rules, array $data): void
    {
        $validator = new RequestValidator();
        $this->expectException(RequestValidationException::class);
        $validator->validate($rules, $data);
    }
}
