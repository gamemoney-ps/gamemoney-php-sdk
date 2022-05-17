<?php

namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class CheckoutPrepareRules
 *
 * @package Gamemoney\Validation\Request\Rules
 */
final class CheckoutPrepareRules implements RulesInterface
{
    /**
     * @inheritdoc
     */
    public function getRules()
    {
        return [
            'project' => [
                new NotBlank(),
                new Type('numeric'),
            ],
            'rand' => [
                new NotBlank(),
                new Length(['min' => 20]),
            ],
            'amount' => [
                new NotBlank(),
                new Type('numeric'),
            ],
            'type' => [
                new NotBlank(),
                new Type('string'),
            ],
            'currency' => [
                new Type('string'),
                new Length(['max' => 4]),
            ],
            'userCurrency' => [
                new Type('string'),
                new Length(['max' => 4]),
            ],
        ];
    }
}
