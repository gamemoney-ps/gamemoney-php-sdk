<?php
namespace tests\Sign;

use PHPUnit\Framework\TestCase;
use Gamemoney\Sign\Signer\BaseSigner;

class ArrayToStringMethodTest extends TestCase {

    public function stringDataProvider()
    {
        return [
            [
                ['data' => ['test' => 1]],
                'data:test:1;;'
            ],
            [
                ['data' => ''],
                'data:;'
            ],
            [
                [
                    'data' => ['test' => 1],
                    'adata' => ['b' => 2, 'a' => 1]
                ],
                'adata:a:1;b:2;;data:test:1;;'
            ],
            [
                [],
                ''
            ]
        ];
    }

    /**
     * @param array $array
     * @param string  $string
     * @dataProvider stringDataProvider
     */
    public function test($array, $string)
    {
        $mock = $this->getMockForAbstractClass(BaseSigner::class);
        $text = $mock->arrayToString($array);
        $this->assertEquals($string, $text);
    }
}