<?php

require_once __DIR__ . '../../../vendor/autoload.php';

$config = [
  'rsaKey' => 'sd',
  'hmacKey' => 'sd',
  'id' => 1
];

$GamemoneyGateway = new \Gamemoney\Gateway($config);
$response = $GamemoneyGateway->getInvoiceStatus(['invoice' => 123]);
var_dump([
  "success" => "true",
  "project" => 123456,
  "invoice" => 2343840,
  "status" => "Paid",
  "time" => 1472620176,
  "rand" => "kd93yhdeuiw38ujHG67s",
  "signature" => "JFDKfKFDHFgzego0JfruT9y+Ut8u7ivkzNSQj+q9icEoRvXCooCGkzPPbkwKc1PDLTVt0m1bll8CxX9twQerpvHCLpDSbqrzwYXg7D1OMD5z/Yi3oHJiwzHk+lASnzgirTLmydv4NL0QmC/nXlmXVbO5An0AC2m+REJH5CABDx7na+rvvEEJQouOET0iOrA750Zt0Rcg2TkHOTgueDsTp+iS7qkyRCzLlw7XEa49pR4HGFzc1lqTYZGGpTOIL9cUT65GB5a/WpTJfU6/DJ58r03VlMPmnshbg4cFmUINYbvnOxTFeiqCu8UAlqCNMfLi+c+IGHdkKDjdj=="
]);
/*