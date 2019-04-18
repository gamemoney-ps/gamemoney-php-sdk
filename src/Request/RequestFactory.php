<?php
namespace Gamemoney\Request;

/**
 * Class RequestFactory
 * Create Request object with needed params
 * @package Gamemoney\Request
 */
class RequestFactory
{
    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#invoice_insert_api)
     * @param array $data
     * @return Request
     */
    public function createInvoice(array $data = [])
    {
        return new Request(RequestInterface::INVOICE_CREATE_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#invoice_status)
     * @param string|int $id invoice id in Gamemoney system
     * @return Request
     */
    public function getInvoiceStatus($id)
    {
        return new Request(RequestInterface::INVOICE_STATUS_ACTION, ['invoice' => $id]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#invoice_status)
     * @param string|int $id invoice id in project system
     * @return Request
     */
    public function getInvoiceStatusByExternalId($id)
    {
        return new Request(RequestInterface::INVOICE_STATUS_ACTION, ['project_invoice' => $id]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#invoice_list)
     * @param array $data
     * @return Request
     */
    public function getInvoiceList(array $data = [])
    {
        return new Request(RequestInterface::INVOICE_LIST_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#checkout_insert)
     * @param array $data
     * @return Request
     */
    public function createCheckout(array $data = [])
    {
        return new Request(RequestInterface::CHECKOUT_CREATE_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#checkout_cancel)
     * @param string|int $id
     * @return Request
     */
    public function cancelCheckout($id)
    {
        return new Request(RequestInterface::CHECKOUT_CANCEL_ACTION, ['projectId' => $id]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#checkout_status)
     * @param string|int $id
     * @return Request
     */
    public function getCheckoutStatus($id)
    {
        return new Request(RequestInterface::CHECKOUT_STATUS_ACTION, ['projectId' => $id]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#checkout_list)
     * @param array $data
     * @return Request
     */
    public function getCheckoutList(array $data = [])
    {
        return new Request(RequestInterface::CHECKOUT_LIST_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#card_add)
     * @param array $data
     * @return Request
     */
    public function addCard(array $data = [])
    {
        return new Request(RequestInterface::CARD_ADD_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#card_list)
     * @param string|int $userId user id in Gamemoney system
     * @return Request
     */
    public function getCardList($userId)
    {
        return new Request(RequestInterface::CARD_LIST_ACTION, ['user' => $userId]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#card_list)
     * @param array $data
     * @return Request
     */
    public function deleteCard(array $data = [])
    {
        return new Request(RequestInterface::CARD_DELETE_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#exchange_prepare)
     * @param array $data
     * @return Request
     */
    public function prepareExchange(array $data = [])
    {
        return new Request(RequestInterface::EXCHANGE_PREPARE_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#exchange_convert)
     * @param array $data
     * @return Request
     */
    public function convertExchange(array $data = [])
    {
        return new Request(RequestInterface::EXCHANGE_CONVERT_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#exchange_fastconvert)
     * @param array $data
     * @return Request
     */
    public function fastConvertExchange(array $data = [])
    {
        return new Request(RequestInterface::EXCHANGE_FAST_CONVERT_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#exchange_info)
     * @param array $data
     * @return Request
     */
    public function getExchangeInfo(array $data = [])
    {
        return new Request(RequestInterface::EXCHANGE_INFO_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#exchange_status)
     * @param int $id exchange response id in Gamemoney system
     * @return Request
     */
    public function getExchangeStatus($id)
    {
        return new Request(RequestInterface::EXCHANGE_STATUS_ACTION, ['id' => $id]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#exchange_status)
     * @param string|int $id exchange id in project system
     * @return Request
     */
    public function getExchangeStatusByExternalId($id)
    {
        return new Request(RequestInterface::EXCHANGE_STATUS_ACTION, ['externalId' => $id]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#stat_balance)
     * @param string $currency
     * @return Request
     */
    public function getBalanceStatistics($currency = null)
    {
        return new Request(
            RequestInterface::STATISTICS_BALANCE_ACTION,
            $currency ? ['currency' => $currency] : []
        );
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#stat_days_balance)
     * @param array $data
     * @return Request
     */
    public function getDaysBalanceStatistics(array $data = [])
    {
        return new Request(RequestInterface::STATISTICS_DAYS_BALANCE_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gamemoney.com/apidoc#stat_paytypes)
     * @return Request
     */
    public function getPayTypesStatistics()
    {
        return new Request(RequestInterface::STATISTICS_PAY_TYPES_ACTION);
    }
}
