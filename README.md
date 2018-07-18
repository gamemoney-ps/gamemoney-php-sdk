# Gamemoney PHP SDK

[![pipeline status](https://git.onmoon.ru/gamemoney/gamemoney-sdk/badges/master/pipeline.svg)](https://git.onmoon.ru/gamemoney/gamemoney-sdk/commits/master) [![coverage report](https://git.onmoon.ru/gamemoney/gamemoney-sdk/badges/master/coverage.svg)](https://git.onmoon.ru/gamemoney/gamemoney-sdk/commits/master)

## Installation

Either run

```sh
php composer.phar gamemoney/php-gamemoney-sdk "*"
```

or add

```sh
"gamemoney/php-gamemoney-sdk": "*"
```

## How-To

```php
$config = [
  'rsaKey' => 'you_rsa_private_key',
  'hmacKey' => 'you_hmac_key',
  'id' => 123456 // project id
];

$GamemoneyGateway = new \Gamemoney\Gateway($config);
$response = $GamemoneyGateway->getInvoiceStatus(['invoice' => 2343840]);
var_dump($resonse);
/*
array(7) {
  'success' =>
  string(4) "true"
  'project' =>
  int(123456)
  'invoice' =>
  int(2343840)
  'status' =>
  string(4) "Paid"
  'time' =>
  int(1472620176)
  'rand' =>
  string(20) "kd93yhdeuiw38ujHG67s"
  'signature' => "..."
  string(335)
}
*/
```