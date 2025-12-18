<?php

namespace Gamemoney\Sign\Signer;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Sign\SignerInterface;

final class EmptySigner implements SignerInterface
{
    public function sign(RequestInterface $request): RequestInterface
    {
        return $request;
    }

    /**
     * @inheritDoc
     */
    public function getSignature(array $data): string
    {
        return '';
    }
}
