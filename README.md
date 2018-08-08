# Gamemoney PHP SDK

[![pipeline status](https://git.onmoon.ru/gamemoney/gamemoney-sdk/badges/master/pipeline.svg)](https://git.onmoon.ru/gamemoney/gamemoney-sdk/commits/master) [![coverage report](https://git.onmoon.ru/gamemoney/gamemoney-sdk/badges/master/coverage.svg)](https://git.onmoon.ru/gamemoney/gamemoney-sdk/commits/master)

* [Installation](#installation)
* [How-To](#how-to)
* [Config examples](#config-examples)
    * [Use keys stored in file](#use-keys-stored-in-file)
    * [Use keys as string](#use-keys-as-string)
* [Full Documentation](#full-documentation)

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
    // for create a invoice create request signature
    'privateKey' => '-----BEGIN ENCRYPTED PRIVATE KEY-----
...
-----END ENCRYPTED PRIVATE KEY-----',
    // passphrase for private key
    'passphrase' => '123',
    // for verification of the answer signature
    'apiPublicKey' => '-----BEGIN PUBLIC KEY-----
...
-----END PUBLIC KEY-----',
     // for create a request signature
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
        'project_invoice' => uniqid(),
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
```
## Config examples

### Use keys stored in file
```php
<?php

$path_to_private_key_file = '/keys/gamemoney/project1/priv.key';
$path_to_public_key_file = '/keys/gamemoney/api/pub.pem';

$config = [
    'privateKey' => file_get_content($path_to_private_key_file),
    // passphrase for private key
    'passphrase' => '123',
    // for verification of the answer signature
    'apiPublicKey' => file_get_content($path_to_public_key_file),
    'hmacKey' => 'test',
    'project' => 1,
];
```
### Use keys as string
```php
<?php

$path_to_private_key_file = '/keys/gamemoney/project1/priv.key';
$path_to_public_key_file = '/keys/gamemoney/api/pub.pem';

$config = [
    'privateKey' => '-----BEGIN PRIVATE KEY-----
...
-----END PRIVATE KEY-----',
        'apiPublicKey' => '-----BEGIN PUBLIC KEY-----
...
-----END PUBLIC KEY-----',
        'hmacKey' => 'test',
        'project' => 1,
];
```
## Full Documentation

http://cp.gamemoney.com/apidoc.php