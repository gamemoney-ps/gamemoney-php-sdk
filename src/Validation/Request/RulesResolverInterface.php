<?php

namespace Gamemoney\Validation\Request;

interface RulesResolverInterface
{
    /**
     * @param array<mixed> $data
     */
    public function resolve(string $action, array $data): RulesInterface;
}
