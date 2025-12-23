<?php

namespace Gamemoney\Sign;

interface SignerResolverInterface
{
    public function resolve(?string $action = null): SignerInterface;
}
