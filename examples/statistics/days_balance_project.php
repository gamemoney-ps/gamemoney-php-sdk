<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$project = 123456;
$hmacKey = 'test';

$certificate = '-----BEGIN CERTIFICATE-----
...
-----END CERTIFICATE-----';

try {
    $config = new \Gamemoney\Config($project, $hmacKey, $certificate);
    $gateway = new \Gamemoney\Gateway($config);
    $requestFactory = new \Gamemoney\Request\RequestFactory();
    $request = $requestFactory->getDaysBalanceStatistics([
        'start' => '2018-01-01',
        'finish' => '2018-01-02',
    ]);
    $response = $gateway->send($request);

    var_dump($response);
} catch (\Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch (\Gamemoney\Exception\GameMoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
