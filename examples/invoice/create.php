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
    $request = $requestFactory->createInvoice([
        'user' => '1',
        'amount' => 200.50,
        'type' => 'applepay',
        'wallet' => '89123456789',
        'project_invoice' => uniqid(),
        'ip' => '72.14.192.0',
        'add_some_field' => 'some value',
    ]);
    $response = $gateway->send($request);

    var_dump($response);
} catch (Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch (Gamemoney\Exception\GameMoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
