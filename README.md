# Gamemoney PHP SDK

* [Installation](#installation)
* [Usage](#usage)
* [Configuration examples](#config-examples)
    * [Using private key stored in file](#using-key-stored-in-file)
    * [Using private key as string](#using-key-as-string)
* [Full Documentation](#full-documentation)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```sh
php composer gamemoney/php-gamemoney-sdk "*"
```

or add

```
"gamemoney/php-gamemoney-sdk": "*"
```

to the require section of your `composer.json` file.

## Usage

```php
<?php
require_once __DIR__ . 'vendor/autoload.php';

$project = 1;
$hmacKey = 'test';
$privateKey = '-----BEGIN ENCRYPTED PRIVATE KEY-----
...
-----END ENCRYPTED PRIVATE KEY-----';

try {
    $config = new \Gamemoney\Config($project, $hmacKey, $privateKey);
    $gateway = new \Gamemoney\Gateway($config);
    $requestFactory = new \Gamemoney\Request\RequestFactory;
    $request = $requestFactory->createInvoice([
        'user' => 1,
        'amount' => 200.50,
        'type' => 'qiwi',
        'wallet' => '89253642685',
        'project_invoice' => uniqid(),
        'ip' => '195.23.43.12',
        'add_some_field' => 'some value'
    ]);
    $response = $gateway->send($request);

    var_dump($response);
} catch (\Gamemoney\Exception\RequestValidationException $e) {
    var_dump($e->getMessage(), $e->getErrors());
} catch (\Gamemoney\Exception\GamemoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
```
## Configuration examples

### Using key stored in file

#### Using `file_get_contents` to get key from file
```php
<?php

$pathToPrivateKeyFile = '/keys/gamemoney/project1/priv.key';

$project = 1;
$hmacKey = 'test';
$privateKey = file_get_contents($pathToPrivateKeyFile);
$privateKeyPass = 'password';

$config = new \Gamemoney\Config($project, $hmacKey, $privateKey, $privateKeyPass);
```
#### Using path in format `file://`

`/keys/gamemoney/project1/priv.key` -- full path to key

```php
<?php

$project = 1;
$hmacKey = 'test';
$pathToPrivateKeyFile = 'file:///keys/gamemoney/project1/priv.key';
$privateKeyPass = 'password';

$config = new \Gamemoney\Config($project, $hmacKey, $pathToPrivateKeyFile, $privateKeyPass);
```

### Using key as string
```php
<?php

$project = 1;
$hmacKey = 'test';
$privateKey = '-----BEGIN PRIVATE KEY-----
...
-----END PRIVATE KEY-----';
$privateKeyPass = 'password';

$config = new \Gamemoney\Config($project, $hmacKey, $privateKey, $privateKeyPass);
```
## Full Documentation

https://cp.gamemoney.com/apidoc
