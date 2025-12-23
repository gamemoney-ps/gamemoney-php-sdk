<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$apiUrl = 'https://example.com';
$project = 123456;
$hmacKey = 'test';

$certificate = '-----BEGIN CERTIFICATE-----
...
-----END CERTIFICATE-----';

try {
    $response = $_POST;
    $config = new \Gamemoney\Config($apiUrl, $project, $hmacKey, $certificate);
    $handler = new \Gamemoney\CallbackHandler\CheckoutCallbackHandler($config);
    if ($handler->check($response)) {
        // your invoice processing
        echo $handler->successAnswer();
    } else {
        echo $handler->errorAnswer();
    }
} catch (\Gamemoney\Exception\GameMoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
