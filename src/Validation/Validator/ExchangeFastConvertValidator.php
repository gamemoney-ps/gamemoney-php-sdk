<?php

namespace Gamemoney\Validation\Validator;

use Gamemoney\Validation\ValidatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

final class ExchangeFastConvertValidator extends BaseValidator implements ValidatorInterface
{
    protected function rules()
    {
        return [
            'project' => [
                new NotBlank(),
                new Type('numeric')
            ],
            'rand' => [
                new NotBlank(),
                new Length(['min' => 20])
            ],
            'from' => [
                new NotBlank(),
                new Type('string'),
                new Length(['max' => 3])
            ],
            'to' => [
                new NotBlank(),
                new Type('string'),
                new Length(['max' => 3])
            ],
            'amount' => [
                new NotBlank(),
                new Type('numeric')
            ],
        ];
    }
}