<?php

namespace Gamemoney\CallbackHandler;

use Gamemoney\Exception\ConfigException;
use Gamemoney\Exception\GameMoneyException;

/**
 * See basic usage example in examples/transfer/callback.php.
 */
class TransferCallbackHandler extends BaseCallbackHandler
{
    private ?int $invoiceNumber;

    public function setInvoiceNumber(?int $invoiceNumber): void
    {
        $this->invoiceNumber = $invoiceNumber;
    }

    public function successAnswer(): string
    {
        if (null === $this->invoiceNumber) {
            throw new ConfigException('Cannot create success answer for TransferCallbackHandler - invoice number not set.');
        }

        $data = [
            'state' => 'success',
            'invoice' => $this->invoiceNumber,
        ];

        $data['signature'] = $this->signerResolver->resolve()->getSignature($data);

        $result = json_encode($data);
        if (false === $result) {
            throw new GameMoneyException('Error within json_encode');
        }

        return $result;
    }

    public function errorAnswer(?string $error = null): string
    {
        $data['state'] = 'error';

        if (!is_null($error)) {
            $data['error'] = $error;
        }

        $data['signature'] = $this->signerResolver->resolve()->getSignature($data);

        $result = json_encode($data);
        if (false === $result) {
            throw new GameMoneyException('Error within json_encode');
        }

        return $result;
    }
}
