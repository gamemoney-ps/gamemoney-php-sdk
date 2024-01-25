<?php

namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

class InvoiceCardSessionCreateRules implements RulesInterface
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
            'user' => [
                new NotBlank(),
                new Type('string'),
                new Length(['max' => 50]),
            ],
        ];
    }
}
