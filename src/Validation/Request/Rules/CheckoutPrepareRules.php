<?php

namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Type;

final class CheckoutPrepareRules implements RulesInterface
{
    /** @var array<mixed> */
    private array $data;

    /**
     * @param array<mixed> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getRules(): array
    {
        $rules = [
            'project' => [
                new NotBlank(),
                new Type('numeric'),
            ],
            'rand' => [
                new NotBlank(),
                new Length(min: 20),
            ],
            'type' => [
                new NotBlank(),
                new Type('string'),
            ],
            'currency' => new Optional([
                new Type('string'),
                new Length(max: 4),
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
                    new Length(max: 4),
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
                    new Length(max: 4),
                ]),
            ]);
        }

        return $rules;
    }
}
