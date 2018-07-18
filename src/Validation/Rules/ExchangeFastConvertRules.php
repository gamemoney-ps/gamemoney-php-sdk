<?php

namespace Gamemoney\Validation\Rules;

use Gamemoney\Validation\RulesInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

final class ExchangeFastConvertRules implements RulesInterface
{
    public function getRules()
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