<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$project = 123456;
$hmacKey = 'test';

try {
    $config = new \Gamemoney\Config($project, $hmacKey);
    $gateway = new \Gamemoney\Gateway($config);
    $requestFactory = new \Gamemoney\Request\RequestFactory();
    $request = $requestFactory->getCardFulllist('1');
    $response = $gateway->send($request);

    var_dump($response);
} catch (\Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch (\Gamemoney\Exception\GamemoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
