<?php

namespace Gamemoney\Request;

interface RequestInterface
{
    public const INVOICE_CREATE_ACTION = '/invoice/';

    public const INVOICE_STATUS_ACTION = '/invoice/status';

    public const INVOICE_LIST_ACTION = '/invoice/list';

    public const INVOICE_ADD_TOKEN_ACTION = '/invoice/addtoken';

    public const CHECKOUT_CREATE_ACTION = '/checkout/insert';

    public const CHECKOUT_CHECK_ACTION = '/checkout/check';

    public const CHECKOUT_PREPARE_ACTION = '/checkout/prepare';

    public const CHECKOUT_CANCEL_ACTION = '/checkout/cancel';

    public const CHECKOUT_STATUS_ACTION = '/checkout/status';

    public const CHECKOUT_LIST_ACTION = '/checkout/list';

    public const CARD_ADD_ACTION = '/card/add';

    public const CARD_ADD_TOKEN_ACTION = '/card/addtoken';

    public const CARD_LIST_ACTION = '/card/list';

    public const CARD_FULL_LIST_ACTION = '/card/fulllist';

    public const CARD_DELETE_ACTION = '/card/delete';

    public const EXCHANGE_PREPARE_ACTION = '/exchange/prepare';

    public const EXCHANGE_CONVERT_ACTION = '/exchange/convert';

    public const EXCHANGE_FAST_CONVERT_ACTION = '/exchange/fastconvert';

    public const EXCHANGE_STATUS_ACTION = '/exchange/status';

    public const EXCHANGE_RATE_ACTION = '/exchange/rate';

    public const STATISTICS_BALANCE_ACTION = '/statistics/balance';

    public const STATISTICS_DAYS_BALANCE_ACTION = '/statistics/days_balance_project';

    public const STATISTICS_PAY_TYPES_ACTION = '/statistics/paytypes';

    public const TERMINAL_CREATE_ACTION = '/terminal/create';

    public function getAction(): string;

    /**
     * @return array<mixed>
     */
    public function getData(): array;

    /**
     * @param array<mixed> $data
     */
    public function setData(array $data): self;

    public function setField(string $field, mixed $value): self;

    public function getField(string $field): mixed;
}
