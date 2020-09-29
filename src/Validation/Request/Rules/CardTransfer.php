<?php

namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class CardTransfer
 * @package Gamemoney\Validation\Request\Rules
 */
final class CardTransfer implements RulesInterface
{
    /**
     * @inheritdoc
     */
    public function getRules()
    {
        return [
            'card_number' => [
                new NotBlank(),
                new Type('string')
            ],
            'cardholder' => [
                new NotBlank(),
                new Type('string'),
                new Length(['max' => 50])
            ],
            'cc_exp_month' => [
                new NotBlank(),
                new Type('string')
            ],
            'cc_exp_year' => [
                new NotBlank(),
                new Type('string')
            ],
        ];
    }
}
