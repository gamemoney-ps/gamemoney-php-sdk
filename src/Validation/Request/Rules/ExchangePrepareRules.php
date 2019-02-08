<?php
namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class ExchangePrepareRules
 * @package Gamemoney\Validation\Request\Rules
 */
final class ExchangePrepareRules implements RulesInterface
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
            'from' => [
                new NotBlank(),
                new Type('string'),
                new Length(['max' => 3])
            ],
            'to' => [
                new NotBlank(),
                new Type('string'),
                new Length(['max' => 3])
            ],
            'minAmount' => [
                new NotBlank(),
                new Type('numeric')
            ],
            'maxAmount' => [
                new NotBlank(),
                new Type('numeric')
            ],
            'livetime' => [
                new Type('numeric')
            ],
        ];
    }
}
