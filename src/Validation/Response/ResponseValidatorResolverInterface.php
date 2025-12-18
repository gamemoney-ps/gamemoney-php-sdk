<?php

namespace Gamemoney\Validation\Response;

/**
 * @package Gamemoney\Validation\Response
 */
interface ResponseValidatorResolverInterface
{
    public function resolve(string $action): ResponseValidatorInterface;
}
