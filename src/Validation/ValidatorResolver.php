<?php
namespace Gamemoney\Validation;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Validation\Validator\InvoiceCreateValidator;
use Gamemoney\Validation\Validator\InvoiceStatusValidator;
use Gamemoney\Validation\Validator\CheckoutCreateValidator;
use Gamemoney\Validation\Validator\CheckoutDefaultValidator;
use Gamemoney\Validation\Validator\CheckoutCheckValidator;
use Gamemoney\Validation\Validator\CardAddValidator;
use Gamemoney\Validation\Validator\CardListValidator;
use Gamemoney\Validation\Validator\CardDeleteValidator;
use Gamemoney\Validation\Validator\ExchangeConvertValidator;
use Gamemoney\Validation\Validator\ExchangeFastConvertValidator;
use Gamemoney\Validation\Validator\ExchangePrepareValidator;
use Gamemoney\Validation\Validator\ExchangeStatusValidator;
use Gamemoney\Validation\Validator\StatisticsBalancesValidator;
use Gamemoney\Validation\Validator\StatisticsDaysBalancesValidator;
use Gamemoney\Validation\Validator\DefaultValidator;

final class ValidatorResolver implements ValidatorResolverInterface
{
    /**
     * @inheritdoc
     */
    public function resolve($action)
    {
        switch($action) {
            case RequestInterface::INVOICE_CREATE_ACTION:
                return new InvoiceCreateValidator;
            case RequestInterface::INVOICE_STATUS_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::CHECKOUT_CREATE_ACTION:
                return new CheckoutCreateValidator;
            case RequestInterface::CHECKOUT_CANCEL_ACTION:
            case RequestInterface::CHECKOUT_STATUS_ACTION:
                return new CheckoutDefaultValidator;
            case RequestInterface::CHECKOUT_CHECK_ACTION:
                return new CheckoutCheckValidator;
            case RequestInterface::CARD_ADD_ACTION:
                return new CardAddValidator;
            case RequestInterface::CARD_LIST_ACTION:
                return new CardListValidator;
            case RequestInterface::CARD_DELETE_ACTION:
                return new CardDeleteValidator;
            case RequestInterface::EXCHANGE_PREPARE_ACTION:
            case RequestInterface::EXCHANGE_INFO_ACTION:
                return new ExchangePrepareValidator;
            case RequestInterface::EXCHANGE_CONVERT_ACTION:
                return new ExchangeConvertValidator;
            case RequestInterface::EXCHANGE_FAST_CONVERT_ACTION:
                return new ExchangeFastConvertValidator;
            case RequestInterface::EXCHANGE_STATUS_ACTION:
                return new ExchangeStatusValidator;
            case RequestInterface::STATISTICS_BALANCE_ACTION:
                return new StatisticsBalancesValidator;
            case RequestInterface::STATISTICS_DAYS_BALANCE_ACTION:
                return new StatisticsDaysBalancesValidator;
            default:
                return new DefaultValidator;
        }
    }
}