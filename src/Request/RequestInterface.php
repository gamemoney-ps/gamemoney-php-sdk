<?php
namespace Gamemoney\Request;

interface RequestInterface
{
    const INVOICE_CREATE_ACTION = '/invoice/';
    const INVOICE_STATUS_ACTION = '/invoice/status';
    const INVOICE_LIST_ACTION = '/invoice/list';
    const CHECKOUT_CREATE_ACTION = '/checkout/insert';
    const CHECKOUT_CANCEL_ACTION = '/checkout/cancel';
    const CHECKOUT_STATUS_ACTION = '/checkout/status';
    const CHECKOUT_LIST_ACTION = '/checkout/list';
    const CARD_ADD_ACTION = '/card/add';
    const CARD_LIST_ACTION = '/card/list';
    const CARD_DELETE_ACTION = '/card/delete';
    const EXCHANGE_PREPARE_ACTION = '/exchange/prepare';
    const EXCHANGE_CONVERT_ACTION = '/exchange/convert';
    const EXCHANGE_FAST_CONVERT_ACTION = '/exchange/fastconvert';
    const EXCHANGE_STATUS_ACTION = '/exchange/status';
    const EXCHANGE_INFO_ACTION = '/exchange/info';
    const STATISTICS_BALANCE_ACTION = '/statistics/balance';
    const STATISTICS_DAYS_BALANCE_ACTION = '/statistics/days_balance_project';
    const STATISTICS_PAY_TYPES_ACTION = '/statistics/paytypes';

    /**
     * @return string request uri
     */
    public function getAction();

    /**
     * @return array request data fields
     */
    public function getData();

    /**
     * @param array $data
     */
    public function setData(array $data);

    /**
     * @param string $field
     * @param mixed $value
     * @return self
     */
    public function setField($field, $value);

    /**
     * @param string $field
     * @return mixed
     */
    public function getField($field);
}
