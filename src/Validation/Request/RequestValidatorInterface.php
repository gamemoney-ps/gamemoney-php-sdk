<?php

namespace Gamemoney\Validation\Request;

interface RequestValidatorInterface
{
    public function validate(array $rules, array $data);
}