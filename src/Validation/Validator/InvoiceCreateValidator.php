<?php

namespace Gamemoney\Validation\Validator;

use Gamemoney\Validation\ValidatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Ip;

final class InvoiceCreateValidator extends BaseValidator implements ValidatorInterface
{
    protected function rules()
    {
        return [
            'project' => [
                new NotBlank(),
                new Type('numeric'),
            ],
            'rand' => [
                new NotBlank(),
                new Length(['min' => 20])
            ],
            'user' => [
                new NotBlank(),
                new Type('numeric'),
            ],
            'amount' => [
                new NotBlank(),
                new Type('numeric'),
            ],
            'type' => [
                new NotBlank(),
                new Type('string')
            ],
            'currency' => [
                new Type('string'),
                new Length(['max' => 3])
            ],
            'user_currency' => [
                new Type('string'),
                new Length(['max' => 3])
            ],
            'language' => [
                new Type('string'),
                new Length(['max' => 2])
            ],
            'project_invoice' => [
                new Type('scalar')
            ],
            'ip' => [
                new Ip()
            ],
        ];
    }
}