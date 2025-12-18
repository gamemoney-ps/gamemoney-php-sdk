<?php

namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

/**
 * @package Gamemoney\Validation\Request\Rules
 */
final class ExchangeStatusRules implements RulesInterface
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

    /**
     * @inheritDoc
     */
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
        ];

        if (isset($this->data['id'])) {
            $rules['id'] = [
                new NotBlank(),
                new Type('numeric'),
            ];
        } elseif (isset($this->data['externalId'])) {
            $rules['externalId'] = [
                new NotBlank(),
                new Type('string'),
            ];
        }

        return $rules;
    }
}
