<?php

namespace tests;

use Gamemoney\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testOptions(): void
    {
        $apiUrl = 'test_url';
        $project = 123;
        $certificate = 'test_certificate';
        $hmac = 'test_hmac';
        $privateKey = '123';
        $privateKeyPassword = '123';

        $config = new Config(
            $apiUrl,
            $project,
            $hmac,
            $certificate,
            $privateKey,
            $privateKeyPassword,
        );

        $this->assertSame($apiUrl, $config->apiUrl());
        $this->assertSame($project, $config->project());
        $this->assertSame($certificate, $config->getCertificate());
        $this->assertSame($hmac, $config->hmac());
        $this->assertSame($privateKey, $config->privateKey());
        $this->assertSame($privateKeyPassword, $config->privateKeyPassword());
    }
}
