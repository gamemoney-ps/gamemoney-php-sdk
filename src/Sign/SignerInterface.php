<?php

namespace Gamemoney\Sign;

use Gamemoney\Request\RequestInterface;

/**
 * Interface SignerInterface
 * @package Gamemoney\Sign
 */
interface SignerInterface
{
    /**
     * @param RequestInterface $request
     * @return RequestInterface $request
     */
    public function sign(RequestInterface $request);

    /**
     * @param array $data
     * @return string
     */
    public function getSignature(array $data);
}
