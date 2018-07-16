<?php

namespace Gamemoney\Validation\Validator;

use Gamemoney\Validation\ValidatorInterface;

final class InvoiceStatusValidator implements ValidatorInterface
{

    private function rules()
    {
        return [

        ];
    }

    public function validate(array $array)
    {
        return true;
    }
}