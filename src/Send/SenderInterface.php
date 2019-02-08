<?php
namespace Gamemoney\Send;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Exception\RequestException;

interface SenderInterface
{
    /**
     * @param RequestInterface $request
     * @return array
     * @throws RequestException
     */
    public function send(RequestInterface $request);
}
