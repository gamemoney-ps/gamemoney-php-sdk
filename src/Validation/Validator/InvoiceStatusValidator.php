<?php

namespace Gamemoney\Validation\Validator;

use Gamemoney\Validation\ValidatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\GreaterThan;

final class InvoiceStatusValidator extends BaseValidator implements ValidatorInterface
{
    protected function rules()
    {
        return [
            'project' => [
                new NotBlank(),
                new GreaterThan(0)
            ],
            'rand' => [
                new NotBlank(),
                new Length(['min' => 20])
            ],
            'invoice' => [
                new NotBlank(),
                new GreaterThan(0)
            ],
        ];
    }
}