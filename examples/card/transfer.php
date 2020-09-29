<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$sessionToken = 'testToken';

try {
    $config = new \Gamemoney\Config\Secure\Config();
    $gateway = new \Gamemoney\Config\Secure\Gateway($config);
    $requestFactory = new \Gamemoney\Request\RequestFactory;

    $request = $requestFactory->transferCard(
        $sessionToken,
        [
            'card_number' => '4000000000000002',
            'cardholder' => 'max payne',
            'cc_exp_month' => '07',
            'cc_exp_year' => '25',
        ]
    );

    $response = $gateway->send($request);

    var_dump($response);
} catch (\Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch (\Gamemoney\Exception\GamemoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}