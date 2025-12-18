<?php

namespace Gamemoney\Sign;

use Gamemoney\Request\RequestInterface;

/**
 * @package Gamemoney\Sign
 */
interface SignerInterface
{
    public function sign(RequestInterface $request): RequestInterface;

    /**
     * @param array<mixed> $data
     */
    public function getSignature(array $data): string;
}
