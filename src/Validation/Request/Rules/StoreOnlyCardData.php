<?php

namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class StoreOnlyCardData
 * @package Gamemoney\Validation\Request\Rules
 */
final class StoreOnlyCardData implements RulesInterface
{
    /**
     * @inheritdoc
     */
    public function getRules()
    {
        return [
            'card_number' => [
                new NotBlank(),
                new Type('string'),
                new Regex([
                        'pattern' => '/^[0-9\s]+$/',
                ]),
            ],
            'cardholder' => [
                new NotBlank(),
                new Type('string'),
                new Length(['max' => 50]),
                new Regex([
                    'pattern' => '/^[\p{L}\s\-\'\'\.]+$/u',
                ]),
            ],
            'cc_exp_month' => [
                new NotBlank(),
                new Type('string'),
                new Regex([
                    'pattern' => '/^(0[1-9]|1[0-2])$/',
                ]),
            ],
            'cc_exp_year' => [
                new NotBlank(),
                new Type('string'),
                new Regex([
                    'pattern' => '/^([0-9]{2})$/',
                ]),
            ],
            'cvc' => new Optional([
                new NotBlank(),
                new Type('string'),
                new Regex([
                    'pattern' => '/^([0-9]{3,4})$/',
                ]),
            ]),
            'email' => new Optional([
                new NotBlank(),
                new Type('string'),
            ]),
        ];
    }
}
