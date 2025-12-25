<?php

namespace Gamemoney\Request;

/**
 * Create Request object with needed params.
 */
class RequestFactory
{
    /**
     * @param array<mixed> $data
     */
    public function createInvoice(array $data = []): Request
    {
        return new Request(RequestInterface::INVOICE_CREATE_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function getInvoiceStatus(array $data = []): Request
    {
        return new Request(RequestInterface::INVOICE_STATUS_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function getInvoiceList(array $data = []): Request
    {
        return new Request(RequestInterface::INVOICE_LIST_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function addTokenInvoice(array $data = []): Request
    {
        return new Request(RequestInterface::INVOICE_ADD_TOKEN_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function createCheckout(array $data = []): Request
    {
        return new Request(RequestInterface::CHECKOUT_CREATE_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function checkCheckout(array $data = []): Request
    {
        return new Request(RequestInterface::CHECKOUT_CHECK_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function prepareCheckout(array $data = []): Request
    {
        return new Request(RequestInterface::CHECKOUT_PREPARE_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function cancelCheckout(array $data = []): Request
    {
        return new Request(RequestInterface::CHECKOUT_CANCEL_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function getCheckoutStatus(array $data = []): Request
    {
        return new Request(RequestInterface::CHECKOUT_STATUS_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function getCheckoutList(array $data = []): Request
    {
        return new Request(RequestInterface::CHECKOUT_LIST_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function addCard(array $data = []): Request
    {
        return new Request(RequestInterface::CARD_ADD_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function getCardList(array $data = []): Request
    {
        return new Request(RequestInterface::CARD_LIST_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function getCardFullList(array $data = []): Request
    {
        return new Request(RequestInterface::CARD_FULL_LIST_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function deleteCard(array $data = []): Request
    {
        return new Request(RequestInterface::CARD_DELETE_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function addTokenCard(array $data = []): Request
    {
        return new Request(RequestInterface::CARD_ADD_TOKEN_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function prepareExchange(array $data = []): Request
    {
        return new Request(RequestInterface::EXCHANGE_PREPARE_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function convertExchange(array $data = []): Request
    {
        return new Request(RequestInterface::EXCHANGE_CONVERT_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function fastConvertExchange(array $data = []): Request
    {
        return new Request(RequestInterface::EXCHANGE_FAST_CONVERT_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function getExchangeRate(array $data = []): Request
    {
        return new Request(RequestInterface::EXCHANGE_RATE_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function getExchangeStatus(array $data = []): Request
    {
        return new Request(RequestInterface::EXCHANGE_STATUS_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function getBalanceStatistics(array $data = []): Request
    {
        return new Request(RequestInterface::STATISTICS_BALANCE_ACTION, $data);
    }

    /**
     * @param array<mixed> $data
     */
    public function getDaysBalanceStatistics(array $data = []): Request
    {
        return new Request(RequestInterface::STATISTICS_DAYS_BALANCE_ACTION, $data);
    }

    public function getPayTypesStatistics(): Request
    {
        return new Request(RequestInterface::STATISTICS_PAY_TYPES_ACTION);
    }

    /**
     * @param array<mixed> $data
     */
    public function createTerminal(array $data = []): Request
    {
        return new Request(RequestInterface::TERMINAL_CREATE_ACTION, $data);
    }
}
