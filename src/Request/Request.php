<?php
namespace Gamemoney\Request;

final class Request implements RequestInterface
{
    private $action;
    private $data;

    public function __construct($action, array $data)
    {
        $this->action = $action;
        $this->data = $data;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getData()
    {
        return $this->data;
    }
}