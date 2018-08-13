<?php
namespace Gamemoney\Request;

interface RequestInterface
{
    const INVOICE_CREATE_ACTION = '/invoice';
    const INVOICE_STATUS_ACTION = '/invoice/status';
    const CHECKOUT_CREATE_ACTION = '/checkout/insert';
    const CHECKOUT_CANCEL_ACTION = '/checkout/cancel';
    const CHECKOUT_STATUS_ACTION = '/checkout/status';
    const CHECKOUT_CHECK_ACTION = '/checkout/check';
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
     * @return string response uri
     */
    public function getAction();

    /**
     * @return array response data fields
     */
    public function getData();

    /**
     * @param array $data
     */
    public function setData(array $data);

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function setField($field, $value);

    /**
     * @param $field
     * @return mixed
     */
    public function getField($field);
}