<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$project = 1;
$user = 'test_user';
$hmacKey = 'test';

try {
    $config = new \Gamemoney\Config($project, $hmacKey);
    $gateway = new \Gamemoney\Gateway($config);
    $requestFactory = new \Gamemoney\Request\RequestFactory();
    $request = $requestFactory->createInvoiceCardSession($project, $user);
    $response = $gateway->send($request);

    var_dump($response);
} catch (\Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch (\Gamemoney\Exception\GameMoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
