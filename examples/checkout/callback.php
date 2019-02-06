<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$config = require __DIR__ . '/../config.php';

try {
    $response = $_POST;
    $handler = new \Gamemoney\CallbackHandler\CheckoutCallbackHandler($config);
    if ($handler->check($response)) {

        // your invoice processing

        echo $handler->successAnswer();
    } else {
        echo $handler->errorAnswer();
    }

} catch(\Gamemoney\Exception\GamemoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
