<?php

namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Ip;

/**
 * Class CheckoutCreateRules
 * @package Gamemoney\Validation\Request\Rules
 */
final class CheckoutCreateRules implements RulesInterface
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
            'projectId' => [
                new NotBlank(),
                new Type('string'),
            ],
            'user' => [
                new NotBlank(),
                new Type('string'),
            ],
            'amount' => [
                new NotBlank(),
                new Type('numeric'),
            ],
            'wallet' => [
                new Type('string'),
            ],
            'description' => [
                new Type('string'),
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
            'ip' => [
                new Ip(['version' => Ip::ALL]),
            ],
        ];
    }
}
