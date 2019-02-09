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
    $request = $requestFactory->createCheckout([
        'projectId' => uniqid(),
        'user' => 1,
        'ip' => '195.23.43.12',
        'amount' => 200.50,
        'wallet' => '89253642685',
        'type' => 'qiwi',
        'project_invoice' => uniqid(),
        'description' => 'Payout for user 250115125',
        'add_some_field' => 'some value'
    ]);
    $response = $gateway->send($request);

    var_dump($response);
} catch (\Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch (\Gamemoney\Exception\GamemoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
