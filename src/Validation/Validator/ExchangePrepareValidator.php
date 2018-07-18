<?php

namespace Gamemoney\Validation\Validator;

use Gamemoney\Validation\ValidatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

final class ExchangePrepareValidator extends BaseValidator implements ValidatorInterface
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
            'minAmount' => [
                new NotBlank(),
                new Type('numeric')
            ],
            'maxAmount' => [
                new NotBlank(),
                new Type('numeric')
            ],
            'livetime' => [
                new Type('numeric')
            ],
        ];
    }
}