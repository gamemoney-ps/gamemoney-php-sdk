<?php
namespace Gamemoney\Validation\Request;

/**
 * Interface RulesResolverInterface
 * @package Gamemoney\Validation\Request
 */
interface RulesResolverInterface
{
    /**
     * @param string $type
     * @return RulesInterface
     */
    public function resolve($type, $data);
}
