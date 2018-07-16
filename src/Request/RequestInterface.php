<?php
namespace Gamemoney\Request;

interface RequestInterface
{
    const INVOICE_STATUS_ACTION = '/invoice/status';
    const CHECKOUT_INSERT_ACTION = '/checkout/insert';

    public function getAction();

    public function getData();
}