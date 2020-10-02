<?php

namespace Gamemoney\Sign\Signer;

use Gamemoney\Request\RequestInterface;

class NotSigner
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
