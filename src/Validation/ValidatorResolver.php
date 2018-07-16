<?php
namespace Gamemoney\Validation;

use Gamemoney\Validation\Validator\InvoiceStatusValidator;

final class ValidatorResolver implements ValidatorResolverInterface
{
    /**
     * @inheritdoc
     */
    public function resolve($type)
    {
        return new InvoiceStatusValidator;
    }
}