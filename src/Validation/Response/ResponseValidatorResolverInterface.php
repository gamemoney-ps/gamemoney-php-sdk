<?php

namespace Gamemoney\Validation\Response;

/**
 * Interface ResponseValidatorResolverInterface
 * @package Gamemoney\Validation\Response
 */
interface ResponseValidatorResolverInterface
{
    /**
     * @param string $action
     * @return ResponseValidatorInterface
     */
    public function resolve($action);
}
