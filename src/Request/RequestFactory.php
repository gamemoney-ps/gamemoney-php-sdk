<?php
namespace Gamemoney\Request;


class RequestFactory
{
    /**
     * @param array $data
     * @return Request
     */
    public function createInvoice(array $data = [])
    {
        return new Request(RequestInterface::INVOICE_CREATE_ACTION, $data);
    }

    /**
     * @param string|int $id
     * @return Request
     */
    public function getInvoiceStatus($id)
    {
        return new Request(RequestInterface::INVOICE_STATUS_ACTION, ['invoice' => $id]);
    }

    /**
     * @param array $data
     * @return Request
     */
    public function createCheckout(array $data = [])
    {
        return new Request(RequestInterface::CHECKOUT_CREATE_ACTION, $data);
    }

    /**
     * @param string|int $id
     * @return Request
     */
    public function cancelCheckout($id)
    {
        return new Request(RequestInterface::CHECKOUT_CANCEL_ACTION, ['projectId' => $id]);
    }

    /**
     * @param string|int $id
     * @return Request
     */
    public function getCheckoutStatus($id)
    {
        return new Request(RequestInterface::CHECKOUT_STATUS_ACTION, ['projectId' => $id]);
    }

    /**
     * @param array $data
     * @return Request
     */
    public  function checkCheckout(array $data = [])
    {
        return new Request(RequestInterface::CHECKOUT_CHECK_ACTION, $data);
    }

    /**
     * @param array $data
     * @return Request
     */
    public function addCard(array $data = [])
    {
        return new Request(RequestInterface::CARD_ADD_ACTION, $data);
    }

    /**
     * @param string|int $userId
     * @return Request
     */
    public function getCardList($userId)
    {
        return new Request(RequestInterface::CARD_LIST_ACTION, ['user' => $userId]);
    }

    /**
     * @param array $data
     * @return Request
     */
    public function deleteCard(array $data = [])
    {
        return new Request(RequestInterface::CARD_DELETE_ACTION, $data);
    }

    /**
     * @param array $data
     * @return Request
     */
    public function prepareExchange(array $data = [])
    {
        return new Request(RequestInterface::EXCHANGE_PREPARE_ACTION, $data);
    }

    /**
     * @param array $data
     * @return Request
     */
    public function convertExchange(array $data = [])
    {
        return new Request(RequestInterface::EXCHANGE_CONVERT_ACTION, $data);
    }

    /**
     * @param array $data
     * @return Request
     */
    public function fastConvertExchange(array $data = [])
    {
        return new Request(RequestInterface::EXCHANGE_FAST_CONVERT_ACTION, $data);
    }

    /**
     * @param array $data
     * @return Request
     */
    public function getExchangeInfo(array $data = [])
    {
        return new Request(RequestInterface::EXCHANGE_INFO_ACTION, $data);
    }

    /**
     * @param int $id
     * @return Request
     */
    public function getExchangeStatus($id)
    {
        return new Request(RequestInterface::EXCHANGE_STATUS_ACTION, ['id' => $id]);
    }

    /**
     * @param string $currency
     * @return Request
     */
    public function getBalanceStatistics($currency = null)
    {
        return new Request(RequestInterface::STATISTICS_BALANCE_ACTION, ['currency' => $currency]);
    }

    /**
     * @param array $data
     * @return Request
     */
    public function getDaysBalanceStatistics(array $data = [])
    {
        return new Request(RequestInterface::STATISTICS_DAYS_BALANCE_ACTION, $data);
    }

    /**
     * @return Request
     */
    public function getPayTypesStatistics()
    {
        return new Request(RequestInterface::STATISTICS_PAY_TYPES_ACTION);
    }
}