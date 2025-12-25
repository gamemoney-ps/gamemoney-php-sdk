<?php

require_once __DIR__.'/../../vendor/autoload.php';

$apiUrl = 'https://example.com';
$project = 123456;
$hmacKey = 'test_key';

$certificate = '-----BEGIN CERTIFICATE-----
...
-----END CERTIFICATE-----';

try {
    $config = new Gamemoney\Config($apiUrl, $project, $hmacKey, $certificate);
    $gateway = new Gamemoney\Gateway($config);
    $requestFactory = new Gamemoney\Request\RequestFactory();
    $request = $requestFactory->prepareExchange([
        'minAmount' => 1000,
        'maxAmount' => 2000.50,
        'from' => 'RUB',
        'to' => 'USD',
    ]);
    $response = $gateway->send($request);

    var_dump($response);
} catch (Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch (Gamemoney\Exception\GameMoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
