<?php

require_once __DIR__ . '../../../vendor/autoload.php';

$config = [
  'rsaKey' => 'sd',
  'hmacKey' => 'sd',
  'id' => 1
];

$GamemoneyGateway = new \Gamemoney\Gateway($config);
$response = $GamemoneyGateway->getInvoiceStatus(['invoice' => 123]);
var_dump($response);
