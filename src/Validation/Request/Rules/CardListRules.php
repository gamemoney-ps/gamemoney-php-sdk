<?php

namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

/**
 * @package Gamemoney\Validation\Request\Rules
 */
final class CardListRules implements RulesInterface
{
    /**
     * @inheritDoc
     */
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
        ];
    }
}
