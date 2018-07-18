<?php

namespace Gamemoney\Validation\Validator;

use Gamemoney\Validation\ValidatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

final class CheckoutDefaultValidator extends BaseValidator implements ValidatorInterface
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
            'projectId' => [
                new NotBlank(),
                new Type('scalar')
            ],
        ];
    }
}