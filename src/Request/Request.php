<?php
namespace Gamemoney\Request;

class Request
{
    protected $action;
    protected $data = [];

    public function __construct($action, array $data = [])
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

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

}