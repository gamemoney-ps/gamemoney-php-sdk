<?php

namespace Gamemoney\Send;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Exception\RequestException;

/**
 * Interface SenderInterface
 * @package Gamemoney\Send
 */
interface SenderInterface
{
    /**
     * @param RequestInterface $request
     * @return array
     * @throws RequestException
     */
    public function send(RequestInterface $request);
}
