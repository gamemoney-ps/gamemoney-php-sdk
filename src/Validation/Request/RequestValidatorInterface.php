<?php

namespace Gamemoney\Validation\Request;

interface RequestValidatorInterface
{
    /**
     * @param array<mixed> $rules
     * @param array<mixed> $data
     */
    public function validate(array $rules, array $data): void;
}
