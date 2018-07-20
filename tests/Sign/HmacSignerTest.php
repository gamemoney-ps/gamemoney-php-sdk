<?php
namespace tests\Sign;

use PHPUnit\Framework\TestCase;
use Gamemoney\Sign\SignerInterface;
use Gamemoney\Sign\Signer\HmacSigner;

class HmacSignerTest extends TestCase {

    protected $key;

    protected function setUp()
    {
        $this->key = 'hmac_key';
    }

    public function testInterface() {
        $signer = new HmacSigner($this->key);
        $this->assertInstanceOf(SignerInterface::class, $signer);
    }

    public function testHmacGetSignature() {
        $fixture = 'f85babd083b7436d63540ca7229ad7257518c148cae52d3d7143d86c215d1b60';
        $Signer = new HmacSigner($this->key);
        $signature = $Signer->getSignature(['data' => ['test' => 1]]);
        $this->assertEquals($fixture, $signature);
    }
}
