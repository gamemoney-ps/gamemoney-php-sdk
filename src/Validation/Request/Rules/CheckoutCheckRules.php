<?php

namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class CheckoutCheckRules
 * @package Gamemoney\Validation\Request\Rules
 */
final class CheckoutCheckRules implements RulesInterface
{
    /**
     * @inheritdoc
     */
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