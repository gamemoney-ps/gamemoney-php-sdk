<?php

namespace tests\Sign\Signer;

use PHPUnit\Framework\TestCase;
use Gamemoney\Sign\SignerInterface;
use Gamemoney\Sign\Signer\HmacSigner;

class HmacSignerTest extends TestCase
{
    const KEY = 'hmac_key';

    public function testInterface()
    {
        $signer = new HmacSigner($this::KEY);
        $this->assertInstanceOf(SignerInterface::class, $signer);
    }

    /**
     * @return array
     */
    public function getSignatureDataProvider()
    {
        return [
            [
                ['data' => ''],
                '3ca52b7c42a68551dc423d7777b5a906b96c3e2b4c1210c68c2de115b26e7164',
            ],
            [
                [
                    'c' => ['test' => 1],
                    'a' => ['b' => 2, 'a' => 1],
                ],
                '1be1385d9c48c54a7fe4dfb390bd2aecdb4a46bf50dc79cd47d7bba5231aacf1',
            ],
            [
                ['data' => ['test' => 1]],
                'f85babd083b7436d63540ca7229ad7257518c148cae52d3d7143d86c215d1b60',
            ],
            [
                [],
                '47799e9c47c18c6172f56309844d010cf204484b4a9a4e62e35384cad504b1e4',
            ],
        ];
    }

    /**
     * @param array $data
     * @param string $fixture
     * @dataProvider getSignatureDataProvider
     */
    public function testHmacGetSignature(array $data, $fixture)
    {
        $signer = new HmacSigner($this::KEY);
        $signature = $signer->getSignature($data);
        $this->assertEquals($fixture, $signature);
    }
}
