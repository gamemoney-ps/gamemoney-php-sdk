<?php
namespace Gamemoney\Request;

final class Request implements RequestInterface
{
    protected $action;
    protected $data = [];

    public function __construct($action, array $data = [])
    {
        if (empty($data['rand'])) {
            $data['rand'] = bin2hex(openssl_random_pseudo_bytes(10));
        }

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

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param string $field
     * @param $value
     * @return $this
     */
    public function setField($field, $value)
    {
        $this->data[$field] = $value;
        return $this;
    }

    /**
     * @param string $field
     * @return mixed
     */
    public function getField($field)
    {
        return $this->data[$field];
    }
}