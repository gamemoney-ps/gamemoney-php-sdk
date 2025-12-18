<?php

namespace Gamemoney\Sign;

/**
 * @package Gamemoney\Sign
 */
interface SignerResolverInterface
{
    public function resolve(?string $action = null): SignerInterface;
}
