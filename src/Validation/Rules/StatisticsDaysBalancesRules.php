<?php

namespace Gamemoney\Validation\Rules;

use Gamemoney\Validation\RulesInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Date;

final class StatisticsDaysBalancesRules implements RulesInterface
{
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
            'currency' => [
                new Type('string'),
                new Length(['max' => 3])
            ],
            'start' => [
                new NotBlank(),
                new Date(),
            ],
            'finish' => [
                new NotBlank(),
                new Date(),
            ],
        ];
    }
}