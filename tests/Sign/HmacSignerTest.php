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

    public function getSignatureDataProvider()
    {
        return [
            [
                ['data' => ['test' => 1]],
                'f85babd083b7436d63540ca7229ad7257518c148cae52d3d7143d86c215d1b60'
            ],
            [
                [],
                'f85babd083b7436d63540ca7229ad7257518c148cae52d3d7143d86c215d1b60'
            ]
        ];
    }

    /**
     * @param mixed $data
     * @param  $signature
     * @dataProvider getSignatureDataProvider
     */
    public function testHmacGetSignature($data, $fixture) {
        $signer = new HmacSigner($this->key);
        $signature = $signer->getSignature(['data' => ['test' => 1]]);
        $this->assertEquals($fixture, $signature);
    }
}
