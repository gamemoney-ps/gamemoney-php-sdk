<?php

namespace Gamemoney\Validation\Request;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Validation\Request\Rules\CardAddtokenRules;
use Gamemoney\Validation\Request\Rules\CheckoutPrepareRules;
use Gamemoney\Validation\Request\Rules\ExchangeRateRules;
use Gamemoney\Validation\Request\Rules\StoreOnlyCardData;
use Gamemoney\Validation\Request\Rules\CheckoutListRules;
use Gamemoney\Validation\Request\Rules\InvoiceCreateRules;
use Gamemoney\Validation\Request\Rules\InvoiceListRules;
use Gamemoney\Validation\Request\Rules\InvoiceStatusRules;
use Gamemoney\Validation\Request\Rules\CheckoutCreateRules;
use Gamemoney\Validation\Request\Rules\CheckoutDefaultRules;
use Gamemoney\Validation\Request\Rules\CardAddRules;
use Gamemoney\Validation\Request\Rules\CardListRules;
use Gamemoney\Validation\Request\Rules\CardDeleteRules;
use Gamemoney\Validation\Request\Rules\ExchangeConvertRules;
use Gamemoney\Validation\Request\Rules\ExchangeFastConvertRules;
use Gamemoney\Validation\Request\Rules\ExchangePrepareRules;
use Gamemoney\Validation\Request\Rules\ExchangeStatusRules;
use Gamemoney\Validation\Request\Rules\StatisticsBalancesRules;
use Gamemoney\Validation\Request\Rules\StatisticsDaysBalancesRules;
use Gamemoney\Validation\Request\Rules\DefaultRules;

/**
 * Class RulesResolver
 * @package Gamemoney\Validation\Request
 */
final class RulesResolver implements RulesResolverInterface
{
    /**
     * @inheritdoc
     */
    public function resolve($action, $data)
    {
        if (preg_match(RequestInterface::STORE_ONLY_CARD_DATA_REGEX, $action)) {
            $action = RequestInterface::STORE_ONLY_CARD_DATA;
        }

        switch ($action) {
            case RequestInterface::INVOICE_CREATE_ACTION:
                return new InvoiceCreateRules();
            case RequestInterface::INVOICE_STATUS_ACTION:
            case RequestInterface::INVOICE_CARD_SESSION_STATUS_ACTION:
                return new InvoiceStatusRules($data);
            case RequestInterface::INVOICE_LIST_ACTION:
                return new InvoiceListRules();
            case RequestInterface::CHECKOUT_CREATE_ACTION:
                return new CheckoutCreateRules();
            case RequestInterface::CHECKOUT_PREPARE_ACTION:
                return new CheckoutPrepareRules();
            case RequestInterface::CHECKOUT_CANCEL_ACTION:
            case RequestInterface::CHECKOUT_STATUS_ACTION:
                return new CheckoutDefaultRules();
            case RequestInterface::CHECKOUT_LIST_ACTION:
                return new CheckoutListRules();
            case RequestInterface::CARD_ADD_ACTION:
                return new CardAddRules();
            case RequestInterface::CARD_ADDTOKEN_ACTION:
                return new CardAddtokenRules();
            case RequestInterface::STORE_ONLY_CARD_DATA:
                return new StoreOnlyCardData();
            case RequestInterface::CARD_LIST_ACTION:
            case RequestInterface::CARD_FULLLIST_ACTION:
                return new CardListRules();
            case RequestInterface::CARD_DELETE_ACTION:
                return new CardDeleteRules();
            case RequestInterface::EXCHANGE_PREPARE_ACTION:
                return new ExchangePrepareRules();
            case RequestInterface::EXCHANGE_RATE_ACTION:
                return new ExchangeRateRules();
            case RequestInterface::EXCHANGE_CONVERT_ACTION:
                return new ExchangeConvertRules();
            case RequestInterface::EXCHANGE_FAST_CONVERT_ACTION:
                return new ExchangeFastConvertRules();
            case RequestInterface::EXCHANGE_STATUS_ACTION:
                return new ExchangeStatusRules($data);
            case RequestInterface::STATISTICS_BALANCE_ACTION:
                return new StatisticsBalancesRules();
            case RequestInterface::STATISTICS_DAYS_BALANCE_ACTION:
                return new StatisticsDaysBalancesRules();
            default:
                return new DefaultRules();
        }
    }
}
