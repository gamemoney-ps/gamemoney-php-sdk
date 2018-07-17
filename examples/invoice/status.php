<?php

require_once __DIR__ . '../../../vendor/autoload.php';

$config = [
    'rsaKey' => 'sd',
    'hmacKey' => 'test',
    'id' => '1',
    'apiUrl' => 'http://paygate.loc'
];

try {
    $GamemoneyGateway = new \Gamemoney\Gateway($config);
    $requestFactory = new requestFactory;
    $request = $requestFactory->get(INVOICE_STATUS_ACTION);
    $request->setData([]);
    $response = $GamemoneyGateway->send($request);



    $request = $GamemoneyGateway->requestFactory(INVOICE_STATUS_ACTION);
//    $request = new \Gamemoney\Request\InvoiceStatusRequest();
//    $request->setInvoice(1);
    $response = $GamemoneyGateway->send($request);
    var_dump($response);
} catch(\Gamemoney\Exception\ValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch(\Gamemoney\Exception\RequestException $e) {
    var_dump($e->getMessage());
}
