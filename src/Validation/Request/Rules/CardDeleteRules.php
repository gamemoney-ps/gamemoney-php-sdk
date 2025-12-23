<?php

namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

final class CardDeleteRules implements RulesInterface
{
    public function getRules(): array
    {
        return [
            'project' => [
                new NotBlank(),
                new Type('numeric'),
            ],
            'rand' => [
                new NotBlank(),
                new Length(min: 20),
            ],
            'user' => [
                new NotBlank(),
                new Type('string'),
            ],
            'pan' => [
                new NotBlank(),
                new Type('string'),
            ],
        ];
    }
}
