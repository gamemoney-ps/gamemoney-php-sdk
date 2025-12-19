<?php

namespace tests;

use Gamemoney\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    const PROJECT = 1;

    const HMAC_KEY = 'test';

    const CERTIFICATE = 'test_certificate';

    const PRIVATE_KEY = '123';

    public function testOptions(): void
    {
        $privateKey = '123';
        $privateKeyPassword = '123';

        $config = new Config(self::PROJECT, self::HMAC_KEY, self::CERTIFICATE, $privateKey, $privateKeyPassword);

        $this->assertSame(self::PROJECT, $config->project());
        $this->assertSame(self::HMAC_KEY, $config->hmac());
        $this->assertSame(self::CERTIFICATE, $config->getCertificate());
        $this->assertSame($privateKey, $config->privateKey());
        $this->assertSame($privateKeyPassword, $config->privateKeyPassword());
    }

    public function testSecureUrl(): void
    {
        $url = Config::SECURE_URL;

        $config = new Config(self::PROJECT, self::HMAC_KEY, self::CERTIFICATE);

        $result = $config->secureUrl();

        $this->assertMatchesRegularExpression('/\/$/', $result);
        $this->assertEquals($url, $result);
    }
}
