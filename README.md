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

require_once __DIR__ . '/vendor/autoload.php';

$project = 123456;
$hmacKey = 'test';
$privateKey = 'YOUR PRIVATE KEY';

try {
    $config = new \Gamemoney\Config($project, $hmacKey, $privateKey);
    $gateway = new \Gamemoney\Gateway($config);
    $requestFactory = new \Gamemoney\Request\RequestFactory;
    $request = $requestFactory->createInvoice([
        'user' => 1,
        'amount' => 200.50,
        'type' => 'qiwi',
        'wallet' => '89123456789',
        'project_invoice' => uniqid(),
        'ip' => '72.14.192.0',
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

## Full Documentation

https://cp.gamemoney.com/apidoc
