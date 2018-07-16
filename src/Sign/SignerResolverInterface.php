<?php

namespace Gamemoney\Sign;

interface SignerResolverInterface
{
    public function resolve($type);
}