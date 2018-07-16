<?php
namespace Gamemoney\Send;

use Gamemoney\Request\RequestInterface;

interface SenderInterface
{
    public function send(RequestInterface $request);
}