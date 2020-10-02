<?php

namespace Gamemoney\Send;

use Gamemoney\Config;

/**
 * Interface SenderResolverInterface
 * @package Gamemoney\Send
 */
interface SenderResolverInterface
{
    /**
     * @param string $action
     * @return SenderInterface
     */
    public function resolve($action);
}
