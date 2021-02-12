<?php

namespace Gamemoney\Sign;

/**
 * Interface SignerResolverInterface
 * @package Gamemoney\Sign
 */
interface SignerResolverInterface
{
    /**
     * @param string|null $action
     * @return SignerInterface
     */
    public function resolve($action = null);
}
