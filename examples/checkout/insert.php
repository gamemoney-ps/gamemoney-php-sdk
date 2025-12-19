<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$project = 123456;
$hmacKey = 'test';

$certificate = '-----BEGIN CERTIFICATE-----
...
-----END CERTIFICATE-----';

$privateKey = '-----BEGIN ENCRYPTED PRIVATE KEY-----
...
-----END ENCRYPTED PRIVATE KEY-----';

$privateKeyPassword = 'keypassword';

try {
    $config = new \Gamemoney\Config($project, $hmacKey, $certificate, $privateKey, $privateKeyPassword);
    $gateway = new \Gamemoney\Gateway($config);
    $requestFactory = new \Gamemoney\Request\RequestFactory();
    $request = $requestFactory->createCheckout([
        'projectId' => uniqid(),
        'user' => '1',
        'ip' => '72.14.192.0',
        'amount' => 200.50,
        'wallet' => '89123456789',
        'type' => 'qiwi',
        'description' => 'Payout for user account 250115125',
        'add_some_field' => 'some value',
    ]);
    $response = $gateway->send($request);

    var_dump($response);
} catch (\Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch (\Gamemoney\Exception\GameMoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
