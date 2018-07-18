<?php
namespace Gamemoney\Validation;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Validation\Rules\InvoiceCreateRules;
use Gamemoney\Validation\Rules\InvoiceStatusRules;
use Gamemoney\Validation\Rules\CheckoutCreateRules;
use Gamemoney\Validation\Rules\CheckoutDefaultRules;
use Gamemoney\Validation\Rules\CheckoutCheckRules;
use Gamemoney\Validation\Rules\CardAddRules;
use Gamemoney\Validation\Rules\CardListRules;
use Gamemoney\Validation\Rules\CardDeleteRules;
use Gamemoney\Validation\Rules\ExchangeConvertRules;
use Gamemoney\Validation\Rules\ExchangeFastConvertRules;
use Gamemoney\Validation\Rules\ExchangePrepareRules;
use Gamemoney\Validation\Rules\ExchangeStatusRules;
use Gamemoney\Validation\Rules\StatisticsBalancesRules;
use Gamemoney\Validation\Rules\StatisticsDaysBalancesRules;
use Gamemoney\Validation\Rules\DefaultRules;

final class RulesResolver implements RulesResolverInterface
{
    /**
     * @inheritdoc
     */
    public function resolve($action)
    {
        switch($action) {
            case RequestInterface::INVOICE_CREATE_ACTION:
                return new InvoiceCreateRules;
            case RequestInterface::INVOICE_STATUS_ACTION:
                return new InvoiceStatusRules;
            case RequestInterface::CHECKOUT_CREATE_ACTION:
                return new CheckoutCreateRules;
            case RequestInterface::CHECKOUT_CANCEL_ACTION:
            case RequestInterface::CHECKOUT_STATUS_ACTION:
                return new CheckoutDefaultRules;
            case RequestInterface::CHECKOUT_CHECK_ACTION:
                return new CheckoutCheckRules;
            case RequestInterface::CARD_ADD_ACTION:
                return new CardAddRules;
            case RequestInterface::CARD_LIST_ACTION:
                return new CardListRules;
            case RequestInterface::CARD_DELETE_ACTION:
                return new CardDeleteRules;
            case RequestInterface::EXCHANGE_PREPARE_ACTION:
            case RequestInterface::EXCHANGE_INFO_ACTION:
                return new ExchangePrepareRules;
            case RequestInterface::EXCHANGE_CONVERT_ACTION:
                return new ExchangeConvertRules;
            case RequestInterface::EXCHANGE_FAST_CONVERT_ACTION:
                return new ExchangeFastConvertRules;
            case RequestInterface::EXCHANGE_STATUS_ACTION:
                return new ExchangeStatusRules;
            case RequestInterface::STATISTICS_BALANCE_ACTION:
                return new StatisticsBalancesRules;
            case RequestInterface::STATISTICS_DAYS_BALANCE_ACTION:
                return new StatisticsDaysBalancesRules;
            default:
                return new DefaultRules;
        }
    }
}