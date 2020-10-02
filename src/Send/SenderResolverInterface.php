<?php

namespace Gamemoney\Send;

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
