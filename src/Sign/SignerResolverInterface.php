<?php

namespace Gamemoney\Sign;

interface SignerResolverInterface
{
    /**
     * @param string $action
     * @return SignerInterface
     */
    public function resolve($action);
}