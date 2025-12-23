<?php

namespace Gamemoney\Send;

use Gamemoney\Exception\RequestException;
use Gamemoney\Request\RequestInterface;

interface SenderInterface
{
    /**
     * @return array<mixed>
     *
     * @throws RequestException
     */
    public function send(RequestInterface $request): array;
}
