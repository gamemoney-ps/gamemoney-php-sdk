<?php

namespace Gamemoney\Send;

/**
 * @package Gamemoney\Send
 */
interface SenderResolverInterface
{
    public function resolve(string $action): SenderInterface;
}
