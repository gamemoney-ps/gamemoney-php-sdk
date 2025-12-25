<?php

require_once __DIR__.'/../../vendor/autoload.php';

$apiUrl = 'https://example.com';
$project = 123456;
$hmacKey = 'test_key';
$invoiceNumber = 123456;

$certificate = '-----BEGIN CERTIFICATE-----
...
-----END CERTIFICATE-----';

try {
    $response = $_POST;
    $config = new Gamemoney\Config($apiUrl, $project, $hmacKey, $certificate);
    $handler = new Gamemoney\CallbackHandler\TransferCallbackHandler($config);
    if ($handler->check($response)) {
        // create invoice and get back an invoice number $invoiceNumber
        $handler->setInvoiceNumber($invoiceNumber);
        echo $handler->getSuccessAnswer();
    } else {
        echo $handler->getErrorAnswer();
    }
} catch (Gamemoney\Exception\GameMoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
