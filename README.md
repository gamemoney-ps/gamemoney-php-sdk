# Gamemoney PHP SDK

[![pipeline status](https://git.onmoon.ru/gamemoney/gamemoney-sdk/badges/master/pipeline.svg)](https://git.onmoon.ru/gamemoney/gamemoney-sdk/commits/master) [![coverage report](https://git.onmoon.ru/gamemoney/gamemoney-sdk/badges/master/coverage.svg)](https://git.onmoon.ru/gamemoney/gamemoney-sdk/commits/master)

* [Installation](#installation)
* [How-To](#how-to)
* [Config examples](#config-examples)
    * [Using keys stored in file](#using-keys-stored-in-file)
    * [Using keys as string](#using-keys-as-string)
* [Full Documentation](#full-documentation)

## Installation

Either run

```sh
php composer gamemoney/php-gamemoney-sdk "*"
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

### Using keys stored in file

#### Using `file_get_content` to get key from file
```php
<?php

$pathToPrivateKeyFile = '/keys/gamemoney/project1/priv.key';
$pathToPublicKeyFile = '/keys/gamemoney/api/pub.pem';

$config = [
    'privateKey' => file_get_content($pathToPrivateKeyFile),
    // passphrase for private key
    'passphrase' => '123',
    // for verification of the answer signature
    'apiPublicKey' => file_get_content($pathToPublicKeyFile),
    'hmacKey' => 'test',
    'project' => 1,
];
```
#### Using path in format `file://`

`/keys/gamemoney/project1/priv.key` -- full path to key

```php
<?php
$pathToPrivateKeyFile = 'file:///keys/gamemoney/project1/priv.key';
$pathToPublicKeyFile = 'file:///keys/gamemoney/project1/pub.pem';

$config = [
    'privateKey' => $pathToPrivateKeyFile,
        'apiPublicKey' => $pathToPublicKeyFile,
        'hmacKey' => 'test',
        'project' => 1,
];
```

### Using keys as string
```php
<?php
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

https://cp.gamemoney.com/apidoc