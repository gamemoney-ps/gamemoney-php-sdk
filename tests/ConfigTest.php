<?php

namespace tests;

use Gamemoney\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testOptions(): void
    {
        $apiUrl = 'test_url';
        $projectId = 123;
        $certificate = 'test_certificate';
        $hmac = 'test_hmac';
        $privateKey = '123';
        $privateKeyPassword = '123';

        $config = new Config(
            $apiUrl,
            $projectId,
            $hmac,
            $certificate,
            $privateKey,
            $privateKeyPassword,
        );

        $this->assertSame($apiUrl, $config->getApiUrl());
        $this->assertSame($projectId, $config->getProject());
        $this->assertSame($certificate, $config->getCertificate());
        $this->assertSame($hmac, $config->getHmac());
        $this->assertSame($privateKey, $config->getPrivateKey());
        $this->assertSame($privateKeyPassword, $config->getPrivateKeyPassword());
    }
}
