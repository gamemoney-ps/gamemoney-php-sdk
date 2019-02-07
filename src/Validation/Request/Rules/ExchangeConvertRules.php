<?php
namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class ExchangeConvertRules
 * @package Gamemoney\Validation\Request\Rules
 */
final class ExchangeConvertRules implements RulesInterface
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
            'id' => [
                new NotBlank(),
                new Type('numeric')
            ],
            'amount' => [
                new NotBlank(),
                new Type('numeric')
            ],
        ];
    }
}
