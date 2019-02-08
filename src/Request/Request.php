<?php
namespace Gamemoney\Request;

/**
 * Class Request
 * @package Gamemoney\Request
 */
final class Request implements RequestInterface
{
    /** @var string */
    private $action;

    /** @var array */
    private $data;

    /**
     * Request constructor.
     * @param string $action URI
     * @param array $data request data array
     */
    public function __construct($action, array $data = [])
    {
        if (empty($data['rand'])) {
            $data['rand'] = bin2hex(openssl_random_pseudo_bytes(10));
        }

        $this->action = $action;
        $this->data = $data;
    }

    /**
     * @inheritdoc
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @inheritdoc
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setField($field, $value)
    {
        $this->data[$field] = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getField($field)
    {
        return $this->data[$field];
    }
}
