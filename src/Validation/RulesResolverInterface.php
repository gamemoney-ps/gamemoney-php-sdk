<?php

namespace Gamemoney\Validation;

interface RulesResolverInterface
{
    /**
     * @param string $type
     * @return RulesInterface
     */
    public function resolve($type);
}