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
<?php
require_once __DIR__ . '../../../vendor/autoload.php';

$config = [
  'privateKey' =>
      "-----BEGIN ENCRYPTED PRIVATE KEY-----
...w
-----END ENCRYPTED PRIVATE KEY-----",
  'hmacKey' => 'test',
  'project' => 1,
];

try {
    $gateway = new \Gamemoney\Gateway($config);
    $requestFactory = new \Gamemoney\Request\RequestFactory;
    $request = $requestFactory->createInvoice([
        'user' => 2,
        'amount' => 200.50,
        'type' => 'qiwi',
        'wallet' => '89253642685',
        'project_invoice' => time(),
        'ip' => '195.23.43.12',
        'add_some_field' => 'some value'
    ]);
    $response = $gateway->send($request);

    var_dump($response);
} catch(\Gamemoney\Exception\ValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch(\Gamemoney\Exception\RequestException $e) {
    var_dump($e->getMessage());
}
*/
```