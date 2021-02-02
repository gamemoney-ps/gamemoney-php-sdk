<?php

namespace Gamemoney\Sign\Signer;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Sign\SignerInterface;

final class EmptySigner implements SignerInterface
{
    /**
     * @param RequestInterface $request
     * @return RequestInterface $request
     */
    public function sign(RequestInterface $request)
    {
        return $request;
    }

    /**
     * @inheritdoc
     */
    public function getSignature(array $data)
    {
        return '';
    }
}
