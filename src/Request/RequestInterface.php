<?php
namespace Gamemoney\Request;

interface RequestInterface
{
//    const INVOICE_CREATE_ACTION = '/invoice';
//    const INVOICE_STATUS_ACTION = '/invoice/status';
//    const CHECKOUT_CREATE_ACTION = '/checkout/insert';
//    const CHECKOUT_CANCEL_ACTION = '/checkout/cancel';
//    const CHECKOUT_STATUS_ACTION = '/checkout/status';
//    const CHECKOUT_CHECK_ACTION = '/checkout/check';
//    const CARD_ADD_ACTION = '/card/add';
//    const CARD_LIST_ACTION = '/card/list';
//    const CARD_DELETE_ACTION = '/card/delete';
//    const EXCHANGE_PREPARE_ACTION = '/exchange/prepare';
//    const EXCHANGE_CONVERT_ACTION = '/exchange/convert';
//    const EXCHANGE_FAST_CONVERT_ACTION = '/exchange/fastconvert';
//    const EXCHANGE_STATUS_ACTION = '/exchange/status';
//    const EXCHANGE_INFO_ACTION = '/exchange/info';
//    const STATISTICS_BALANCE_ACTION = '/statistics/balance';
//    const STATISTICS_DAYS_BALANCE_ACTION = '/statistics/days_balance_project';
//    const STATISTICS_PAYTYPES_ACTION = '/statistics/paytypes';


    const INVOICE_CREATE_ACTION = '/paygate/invoice.php';
    const INVOICE_STATUS_ACTION = '/paygate/invoice.php?0=status';
    const CHECKOUT_CREATE_ACTION = '/paygate/checkout.php?0=insert';
    const CHECKOUT_CANCEL_ACTION = '/paygate/checkout.php?0=cancel';
    const CHECKOUT_STATUS_ACTION = '/paygate/checkout.php?0=status';
    const CHECKOUT_CHECK_ACTION = '/paygate/checkout.php?0=check';
    const CARD_ADD_ACTION = '/paygate/card.php?0=add';
    const CARD_LIST_ACTION = '/paygate/card.php?0=list';
    const CARD_DELETE_ACTION = '/paygate/card.php?0=delete';
    const EXCHANGE_PREPARE_ACTION = '/paygate/exchange.php?0=prepare';
    const EXCHANGE_CONVERT_ACTION = '/paygate/exchange.php?0=convert';
    const EXCHANGE_FAST_CONVERT_ACTION = '/paygate/exchange.php?0=fastconvert';
    const EXCHANGE_STATUS_ACTION = '/paygate/exchange.php?0=status';
    const EXCHANGE_INFO_ACTION = '/paygate/exchange.php?0=info';
    const STATISTICS_BALANCE_ACTION = '/paygate/statistics.php?0=balance';
    const STATISTICS_DAYS_BALANCE_ACTION = '/paygate/statistics.php?0=days_balance_project';
    const STATISTICS_PAYTYPES_ACTION = '/paygate/statistics.php?0=paytypes';

    /**
     * @return string
     */
    public function getAction();

    /**
     * @return array
     */
    public function getData();

    /**
     * @param array $data
     */
    public function setData($data);
}