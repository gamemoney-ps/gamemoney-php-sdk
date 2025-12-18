<?php

namespace Gamemoney\Validation\Request;

/**
 * @package Gamemoney\Validation\Request
 */
interface RulesInterface
{
    /**
     * @return array<mixed>
     */
    public function getRules(): array;
}
