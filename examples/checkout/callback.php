<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$project = 123456;
$hmacKey = 'test';

try {
    $response = $_POST;
    $config = new \Gamemoney\Config\Paygate\Config($project, $hmacKey);
    $handler = new \Gamemoney\CallbackHandler\CheckoutCallbackHandler($config);
    if ($handler->check($response)) {
        // your invoice processing
        echo $handler->successAnswer();
    } else {
        echo $handler->errorAnswer();
    }
} catch (\Gamemoney\Exception\GamemoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
