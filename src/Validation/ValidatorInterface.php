<?php

namespace Gamemoney\Validation;

interface ValidatorInterface
{
    public function validate(array $rules, array $data);
}