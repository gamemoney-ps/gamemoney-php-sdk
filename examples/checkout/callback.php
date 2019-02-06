<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$project = 1;
$hmacKey = 'test';
$privateKey = '-----BEGIN ENCRYPTED PRIVATE KEY-----
...
-----END ENCRYPTED PRIVATE KEY-----';

try {
    $response = $_POST;
    $config = new \Gamemoney\Config($project, $hmacKey, $privateKey);
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
