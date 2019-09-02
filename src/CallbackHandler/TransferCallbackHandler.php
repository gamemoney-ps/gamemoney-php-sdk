<?php
namespace Gamemoney\CallbackHandler;

use Gamemoney\Exception\ConfigException;

/**
 * Class TransferCallbackHandler
 * See basic usage example in examples/transfer/callback.php
 * @package Gamemoney
 */
class TransferCallbackHandler extends BaseCallbackHandler
{
    /** @var int|null */
    private $invoiceNumber;

    /**
     * @param string $invoiceNumber
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
    }

    /**
     * @return string
     */
    public function successAnswer()
    {
        if ($this->invoiceNumber === null) {
            throw new ConfigException(
                'Cannot create success answer for TransferCallbackHandler - invoice number not set.'
            );
        }

        return json_encode([
            'state' => 'success',
            'invoice' => $this->invoiceNumber
        ]);
    }

    /**
     * @param string|null $error
     * @return string
     */
    public function errorAnswer($error = null)
    {
        return json_encode(
            array_merge(
                ['state' => 'error'],
                $error ? ['error' => $error] : []
            )
        );
    }
}
