<?php

namespace Gamemoney\Request;

/**
 * Create Request object with needed params
 * @package Gamemoney\Request
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

    public function getInvoiceStatus(int $id): Request
    {
        return new Request(RequestInterface::INVOICE_STATUS_ACTION, ['invoice' => $id]);
    }

    public function getInvoiceStatusByExternalId(string $id): Request
    {
        return new Request(RequestInterface::INVOICE_STATUS_ACTION, ['project_invoice' => $id]);
    }

    /**
     * @param array<mixed> $data
     */
    public function getInvoiceList(array $data = []): Request
    {
        return new Request(RequestInterface::INVOICE_LIST_ACTION, $data);
    }

    public function createInvoiceCardSession(int $project, string $user): Request
    {
        return new Request(RequestInterface::INVOICE_CREATE_CARD_SESSION, [
            'project' => $project,
            'user' => $user,
        ]);
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

    public function cancelCheckout(string $id): Request
    {
        return new Request(RequestInterface::CHECKOUT_CANCEL_ACTION, ['projectId' => $id]);
    }

    public function getCheckoutStatus(string $id): Request
    {
        return new Request(RequestInterface::CHECKOUT_STATUS_ACTION, ['projectId' => $id]);
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

    public function getCardList(string $userId): Request
    {
        return new Request(RequestInterface::CARD_LIST_ACTION, ['user' => $userId]);
    }

    public function getCardFullList(string $userId): Request
    {
        return new Request(RequestInterface::CARD_FULLLIST_ACTION, ['user' => $userId]);
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
        return new Request(RequestInterface::CARD_ADDTOKEN_ACTION, $data);
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

    public function getExchangeStatus(int $id): Request
    {
        return new Request(RequestInterface::EXCHANGE_STATUS_ACTION, ['id' => $id]);
    }

    public function getExchangeStatusByExternalId(string $id): Request
    {
        return new Request(RequestInterface::EXCHANGE_STATUS_ACTION, ['externalId' => $id]);
    }

    public function getBalanceStatistics(?string $currency = null): Request
    {
        return new Request(
            RequestInterface::STATISTICS_BALANCE_ACTION,
            $currency ? ['currency' => $currency] : [],
        );
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
