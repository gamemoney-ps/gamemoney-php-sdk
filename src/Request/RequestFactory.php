<?php
namespace Gamemoney\Request;


class RequestFactory
{
    public function getInstance($action)
    {
        return new Request($action);
    }
}