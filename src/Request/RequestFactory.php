<?php

namespace Gamemoney\Request;

/**
 * Create Request object with needed params
 * @package Gamemoney\Request
 */
class RequestFactory
{
    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#invoice_insert_api)
     * @param array<mixed> $data
     */
    public function createInvoice(array $data = []): Request
    {
        return new Request(RequestInterface::INVOICE_CREATE_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#invoice_status)
     */
    public function getInvoiceStatus(int $id): Request
    {
        return new Request(RequestInterface::INVOICE_STATUS_ACTION, ['invoice' => $id]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#invoice_status)
     */
    public function getInvoiceStatusByExternalId(string $id): Request
    {
        return new Request(RequestInterface::INVOICE_STATUS_ACTION, ['project_invoice' => $id]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#invoice_list)
     * @param array<mixed> $data
     */
    public function getInvoiceList(array $data = []): Request
    {
        return new Request(RequestInterface::INVOICE_LIST_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#invoice_add_token)
     */
    public function createInvoiceCardSession(int $project, string $user): Request
    {
        return new Request(RequestInterface::INVOICE_CREATE_CARD_SESSION, [
            'project' => $project,
            'user' => $user,
        ]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#checkout_insert)
     * @param array<mixed> $data
     */
    public function createCheckout(array $data = []): Request
    {
        return new Request(RequestInterface::CHECKOUT_CREATE_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#checkout_check)
     * @param array<mixed> $data
     */
    public function checkCheckout(array $data = []): Request
    {
        return new Request(RequestInterface::CHECKOUT_CHECK_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#checkout_prepare)
     * @param array<mixed> $data
     */
    public function prepareCheckout(array $data = []): Request
    {
        return new Request(RequestInterface::CHECKOUT_PREPARE_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#checkout_cancel)
     */
    public function cancelCheckout(string $id): Request
    {
        return new Request(RequestInterface::CHECKOUT_CANCEL_ACTION, ['projectId' => $id]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#checkout_status)
     */
    public function getCheckoutStatus(string $id): Request
    {
        return new Request(RequestInterface::CHECKOUT_STATUS_ACTION, ['projectId' => $id]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#checkout_list)
     * @param array<mixed> $data
     */
    public function getCheckoutList(array $data = []): Request
    {
        return new Request(RequestInterface::CHECKOUT_LIST_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#card_add)
     * @param array<mixed> $data
     */
    public function addCard(array $data = []): Request
    {
        return new Request(RequestInterface::CARD_ADD_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#card_list)
     */
    public function getCardList(string $userId): Request
    {
        return new Request(RequestInterface::CARD_LIST_ACTION, ['user' => $userId]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#card_fulllist)
     */
    public function getCardFullList(string $userId): Request
    {
        return new Request(RequestInterface::CARD_FULLLIST_ACTION, ['user' => $userId]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#card_delete)
     * @param array<mixed> $data
     */
    public function deleteCard(array $data = []): Request
    {
        return new Request(RequestInterface::CARD_DELETE_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#card_add_token)
     * @param array<mixed> $data
     */
    public function addTokenCard(array $data = []): Request
    {
        return new Request(RequestInterface::CARD_ADDTOKEN_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#card_send_card_data) and [docs](https://cp.gmpays.com/apidoc#invoice_card_send_data)
     * @param array<mixed> $data
     */
    public function storeOnlyCardData(string $sessionToken, array $data = []): Request
    {
        $url = sprintf(RequestInterface::STORE_ONLY_CARD_DATA, $sessionToken);

        return new Request($url, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#exchange_prepare)
     * @param array<mixed> $data
     */
    public function prepareExchange(array $data = []): Request
    {
        return new Request(RequestInterface::EXCHANGE_PREPARE_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#exchange_convert)
     * @param array<mixed> $data
     */
    public function convertExchange(array $data = []): Request
    {
        return new Request(RequestInterface::EXCHANGE_CONVERT_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#exchange_fastconvert)
     * @param array<mixed> $data
     */
    public function fastConvertExchange(array $data = []): Request
    {
        return new Request(RequestInterface::EXCHANGE_FAST_CONVERT_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#exchange_rate)
     * @param array<mixed> $data
     */
    public function getExchangeRate(array $data = []): Request
    {
        return new Request(RequestInterface::EXCHANGE_RATE_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#exchange_status)
     */
    public function getExchangeStatus(int $id): Request
    {
        return new Request(RequestInterface::EXCHANGE_STATUS_ACTION, ['id' => $id]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#exchange_status)
     */
    public function getExchangeStatusByExternalId(string $id): Request
    {
        return new Request(RequestInterface::EXCHANGE_STATUS_ACTION, ['externalId' => $id]);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#stat_balance)
     */
    public function getBalanceStatistics(?string $currency = null): Request
    {
        return new Request(
            RequestInterface::STATISTICS_BALANCE_ACTION,
            $currency ? ['currency' => $currency] : [],
        );
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#stat_days_balance)
     * @param array<mixed> $data
     */
    public function getDaysBalanceStatistics(array $data = []): Request
    {
        return new Request(RequestInterface::STATISTICS_DAYS_BALANCE_ACTION, $data);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#stat_paytypes)
     */
    public function getPayTypesStatistics(): Request
    {
        return new Request(RequestInterface::STATISTICS_PAY_TYPES_ACTION);
    }

    /**
     * For more details and usage information see [docs](https://cp.gmpays.com/apidoc#invoice_api_terminal)
     * @param array<mixed> $data
     */
    public function createTerminal(array $data = []): Request
    {
        return new Request(RequestInterface::TERMINAL_CREATE_ACTION, $data);
    }
}
