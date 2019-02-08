<?php
namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Gateway;
use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class InvoiceListRules
 * @package Gamemoney\Validation\Request\Rules
 */
final class InvoiceListRules implements RulesInterface
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
            'start' => [
                new NotBlank(),
                new DateTime()
            ],
            'finish' => [
                new NotBlank(),
                new DateTime()
            ],
        ];
    }
}
