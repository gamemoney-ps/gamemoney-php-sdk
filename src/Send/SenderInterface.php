<?php

namespace Gamemoney\Send;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Exception\RequestException;

/**
 * @package Gamemoney\Send
 */
interface SenderInterface
{
    /**
     * @return array<mixed>
     * @throws RequestException
     */
    public function send(RequestInterface $request): array;
}
