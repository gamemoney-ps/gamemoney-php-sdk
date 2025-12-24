<?php

require_once __DIR__.'/../../vendor/autoload.php';

$apiUrl = 'https://example.com';
$project = 123456;
$hmacKey = 'test';

$certificate = '-----BEGIN CERTIFICATE-----
...
-----END CERTIFICATE-----';

try {
    $config = new Gamemoney\Config($apiUrl, $project, $hmacKey, $certificate);
    $gateway = new Gamemoney\Gateway($config);
    $requestFactory = new Gamemoney\Request\RequestFactory();
    $request = $requestFactory->getCardFullList('1');
    $response = $gateway->send($request);

    var_dump($response);
} catch (Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch (Gamemoney\Exception\GameMoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
