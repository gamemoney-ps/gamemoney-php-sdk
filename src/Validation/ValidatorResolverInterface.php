<?php

namespace Gamemoney\Validation;

interface ValidatorResolverInterface
{
    /**
     * @param string $type
     * @return ValidatorInterface
     */
    public function resolve($type);
}