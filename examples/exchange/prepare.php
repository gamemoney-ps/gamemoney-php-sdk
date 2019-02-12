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
    $request = $requestFactory->prepareExchange([
        'externalId' => uniqid(),
        'minAmount' => 1000,
        'maxAmount' => 2000.50,
        'from' => 'RUB',
        'to' => 'USD',
        'livetime' => '600'
    ]);
    $response = $gateway->send($request);

    var_dump($response);
} catch (\Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch (\Gamemoney\Exception\GamemoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
