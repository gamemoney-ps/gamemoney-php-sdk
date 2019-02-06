<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$config = [
    'apiPublicKey' => '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAx5B70y7kaFJ8yte7dsdt
vuPYNfN2j1hJSChPuOM4oWY8uUmmGl6f33CJQ69IClWle9I3HIUm81yT3QCVnD7l
r/JYse6cI2vILIaIdvmqu6VcDaiv+O+sUbPoRxq9lxfY5GnHFSrzUBy1yDugCuAE
TM2iRnHpYHbbILDrVs9csfLEeaJ56zn5kan9qJM4ecPKPXv6OabGHK9JkROxQyya
YJPk0mrA98jGvh9/ZrZxQuvH/Kvh61SXC3cpidKkIsCyw2vr0x6A5RnGU8q9fLdW
Ua4nSr1picTSmbryCb/zVGtH4ZgNXFYl7peQu7qNOeohyQFgwAtaYeg/NEDz90nu
sQIDAQAB
-----END PUBLIC KEY-----'
];

try {
    $response = $_POST;
    $handler = new \Gamemoney\CallbackHandler\InvoiceCallbackHandler($config);
    if($handler->check($response)) {

        // your invoice processing

        echo $handler->successAnswer();
    } else {
        echo $handler->errorAnswer();
    }

} catch(\Gamemoney\Exception\GamemoneyExceptionInterface $e) {
    var_dump($e->getMessage());
}
