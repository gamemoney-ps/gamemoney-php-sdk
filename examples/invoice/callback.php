<?php

require_once __DIR__ . '../../../vendor/autoload.php';

$config = require(__DIR__.'/../config.php');

try {
    $response = $_POST;
    $handler = new \Gamemoney\CallbackHandler\InvoiceCallbackHandler($config);
    if($handler->check($response)) {

        // your invoice processing

        echo json_encode(['success' => true]);
    }

} catch(\Gamemoney\Exception\GamemoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
