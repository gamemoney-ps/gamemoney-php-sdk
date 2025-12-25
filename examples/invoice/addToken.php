<?php

require_once __DIR__.'/../../vendor/autoload.php';

$apiUrl = 'https://example.com';
$project = 1;
$hmacKey = 'test_key';

$certificate = '-----BEGIN CERTIFICATE-----
...
-----END CERTIFICATE-----';

try {
    $config = new Gamemoney\Config($apiUrl, $project, $hmacKey, $certificate);
    $gateway = new Gamemoney\Gateway($config);
    $requestFactory = new Gamemoney\Request\RequestFactory();
    $request = $requestFactory->addTokenInvoice([
        'user' => 'test_user',
    ]);
    $response = $gateway->send($request);

    var_dump($response);
} catch (Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch (Gamemoney\Exception\GameMoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
