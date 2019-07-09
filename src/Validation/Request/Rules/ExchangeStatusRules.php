<?php
namespace Gamemoney\Validation\Request\Rules;

use Gamemoney\Validation\Request\RulesInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class ExchangeStatusRules
 * @package Gamemoney\Validation\Request\Rules
 */
final class ExchangeStatusRules implements RulesInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * ExchangeStatusRules constructor.
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
                new Type('numeric')
            ],
            'rand' => [
                new NotBlank(),
                new Length(['min' => 20])
            ],
        ];

        if (isset($this->data['id'])) {
            $rules['id'] = [
                new NotBlank(),
                new Type('numeric')
            ];
        } elseif (isset($this->data['externalId'])) {
            $rules['externalId'] = [
                new NotBlank(),
                new Type('string')
            ];
        }

        return $rules;
    }
}
