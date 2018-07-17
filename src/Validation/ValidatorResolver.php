<?php
namespace Gamemoney\Validation;

use Gamemoney\Request\RequestInterface;
use Gamemoney\Validation\Validator\InvoiceStatusValidator;

final class ValidatorResolver implements ValidatorResolverInterface
{
    /**
     * @inheritdoc
     */
    public function resolve($action)
    {
        switch($action) {
            case RequestInterface::INVOICE_CREATE_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::INVOICE_STATUS_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::CHECKOUT_CREATE_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::CHECKOUT_CANCEL_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::CHECKOUT_STATUS_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::CHECKOUT_CHECK_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::CARD_ADD_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::CARD_LIST_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::CARD_DELETE_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::EXCHANGE_PREPARE_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::EXCHANGE_CONVERT_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::EXCHANGE_FAST_CONVERT_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::EXCHANGE_STATUS_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::EXCHANGE_INFO_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::STATISTICS_BALANCE_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::STATISTICS_DAYS_BALANCE_ACTION:
                return new InvoiceStatusValidator;
            case RequestInterface::STATISTICS_PAYTYPES_ACTION:
                return new InvoiceStatusValidator;
        }
    }


}