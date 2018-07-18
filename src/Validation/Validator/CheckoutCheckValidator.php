<?php

namespace Gamemoney\Validation\Validator;

use Gamemoney\Validation\ValidatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

final class CheckoutCheckValidator extends BaseValidator implements ValidatorInterface
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
            'user' => [
                new NotBlank(),
                new Type('numeric')
            ],
            'type' => [
                new NotBlank(),
                new Type('string')
            ],
            'wallet' => [
                new NotBlank(),
                new Type('string')
            ],
        ];
    }
}