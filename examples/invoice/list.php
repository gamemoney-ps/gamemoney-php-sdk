<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$config = require __DIR__.'/../config.php';

try {
    $gateway = new \Gamemoney\Gateway($config);
    $requestFactory = new \Gamemoney\Request\RequestFactory;
    $request = $requestFactory->getInvoiceList(
        new DateTimeImmutable('2018-10-09 23:00:00'),
        new DateTimeImmutable('now')
    );
    $response = $gateway->send($request);

    var_dump($response);
} catch(\Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch(\Gamemoney\Exception\GamemoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
