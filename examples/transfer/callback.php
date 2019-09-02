<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$project = 123456;
$hmacKey = 'test';

try {
    $response = $_POST;
    $config = new \Gamemoney\Config($project, $hmacKey);
    $handler = new \Gamemoney\CallbackHandler\TransferCallbackHandler($config);
    if ($handler->check($response)) {
        // create invoice and get back an invoice number $invoiceNumber
        $handler->setInvoiceNumber($invoiceNumber);
        echo $handler->successAnswer();
    } else {
        echo $handler->errorAnswer();
    }
} catch (\Gamemoney\Exception\GamemoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
