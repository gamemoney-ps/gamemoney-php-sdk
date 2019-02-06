<?php

require_once __DIR__ . '/../../vendor/autoload.php';

/** @var array $config */
$config = require __DIR__.'/../config.php';

try {
    $gateway = new \Gamemoney\Gateway(
        new \Gamemoney\Config($config['project'], $config['hmacKey'], $config['privateKey'])
    );
    $requestFactory = new \Gamemoney\Request\RequestFactory;
    $request = $requestFactory->getInvoiceStatus(123);
    $response = $gateway->send($request);

    var_dump($response);
} catch(\Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch(\Gamemoney\Exception\GamemoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
