<?php
namespace Gamemoney\Validation\Request;

/**
 * Interface RequestValidatorInterface
 * @package Gamemoney\Validation\Request
 */
interface RequestValidatorInterface
{
    /**
     * @param array $rules
     * @param array $data
     */
    public function validate(array $rules, array $data);
}
