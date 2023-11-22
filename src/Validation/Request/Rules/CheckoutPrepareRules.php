<?php

namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
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
     * @var array
     */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @inheritdoc
     */
    public function getRules()
    {
        $rules = [
            'project' => [
                new NotBlank(),
                new Type('numeric'),
            ],
            'rand' => [
                new NotBlank(),
                new Length(['min' => 20]),
            ],
            'type' => [
                new NotBlank(),
                new Type('string'),
            ],
            'currency' => new Optional([
                new Type('string'),
                new Length(['max' => 4]),
            ]),
        ];

        if (isset($this->data['paid_amount'])) {
            $rules = array_merge($rules, [
                'paid_amount' => [
                    new NotBlank(),
                    new Type('numeric'),
                ],
                'userCurrency' => [
                    new Type('string'),
                    new Length(['max' => 4]),
                ],
            ]);
        } else {
            $rules = array_merge($rules, [
                'amount' => [
                    new NotBlank(),
                    new Type('numeric'),
                ],
                'userCurrency' => new Optional([
                    new Type('string'),
                    new Length(['max' => 4]),
                ]),
            ]);
        }

        return $rules;
    }
}
