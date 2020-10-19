<?php
namespace tests;

use Gamemoney\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testOptions()
    {
        $project = 1;
        $hmacKey = 'test';
        $privateKey = '123';
        $privateKeyPassword = '123';

        $config = new Config($project, $hmacKey, $privateKey, $privateKeyPassword);

        $this->assertSame($project, $config->project());
        $this->assertSame($hmacKey, $config->hmac());
        $this->assertSame($privateKey, $config->privateKey());
        $this->assertSame($privateKeyPassword, $config->privateKeyPassword());
    }

    public function testGmCertificate()
    {
        $project = 1;
        $hmacKey = 'test';

        $config = new Config($project, $hmacKey);

        $this->assertFileExists($config->gmCertificate());
    }
}
