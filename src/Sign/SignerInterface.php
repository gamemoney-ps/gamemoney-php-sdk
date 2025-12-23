<?php

namespace Gamemoney\Sign;

use Gamemoney\Request\RequestInterface;

interface SignerInterface
{
    public function sign(RequestInterface $request): RequestInterface;

    /**
     * @param array<mixed> $data
     */
    public function getSignature(array $data): string;
}
