<?php

namespace Gamemoney\Sign\Signer;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Sign\SignerInterface;

final class NotSigner implements SignerInterface
{
    /**
     * @param RequestInterface $request
     * @return RequestInterface $request
     */
    public function sign(RequestInterface $request)
    {
        return $request;
    }
}
