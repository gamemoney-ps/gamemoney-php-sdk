<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$project = 1;
$hmacKey = 'test';
$privateKey = '-----BEGIN ENCRYPTED PRIVATE KEY-----
...
-----END ENCRYPTED PRIVATE KEY-----';

try {
    $config = new \Gamemoney\Config($project, $hmacKey, $privateKey);
    $gateway = new \Gamemoney\Gateway($config);
    $requestFactory = new \Gamemoney\Request\RequestFactory;
    $request = $requestFactory->convertExchange([
        'id' => 1,
        'amount' => 1000
    ]);
    $response = $gateway->send($request);

    var_dump($response);
} catch (\Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch (\Gamemoney\Exception\GamemoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
