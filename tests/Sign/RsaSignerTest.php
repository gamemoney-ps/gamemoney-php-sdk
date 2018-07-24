<?php
namespace tests\Sign;

use PHPUnit\Framework\TestCase;
use Gamemoney\Sign\SignerInterface;
use Gamemoney\Sign\Signer\RsaSigner;

class RsaSignerTest extends TestCase {

    private $privateKey;
    private $passphrase;

    protected function setUp()
    {
        $this->privateKey = $this->getPrivateKey();
        $this->passphrase = 123;
    }

    public function testInterface() {
        $signer = new RsaSigner($this->privateKey, $this->passphrase);
        $this->assertInstanceOf(SignerInterface::class, $signer);
    }

    public function getSignatureDataProvider()
    {
        return [
            [
                ['data' => ''],
                'i/iI9c8w9ZdxjNSj0z7QlFw1RVlu/9Vm/llCE5n6yEH+AfZBRb9ttxWaCUZTNlH3S+v7hfxiZCBRk4JJfsTtzooFFH1T8c2YiLAj+sPn1XYE8Jx1MYxoZe9ImCo3p0F1NK1BSRJCuJ+gVcMjmIIDNNHNBVN30Jl+z1tXT5Q13T32npEkOxzfFqBnEVSRHVM5rMtH2rfnfZLYGOGTreCgEWc2zO7WzxfsQAGjhs8XnAZECDLHhetvfmecSiulMx+DW91zxhsNSVdIB6GFXKSDBAP/aXUhdkJGx8tj01dLKw/fRcKF1ftj/Pj4/BDRk0SPMd9NyJ0pdShXeS7OucCGOQ=='
            ],
            [
                [
                    'c' => ['test' => 1],
                    'a' => ['b' => 2, 'a' => 1]
                ],
                'vEwmskNtI8Nnsvzxh/i6HCNH0tuQLmXzd4wGPKyoO+4QyRCDNP4PDYmwnGntp84JHoRXXdaontsYZE52ZV2PeJ+qXk3oupWSs+pPQ+hBeZYC2tZ11qPtHr/qarmZokWML2o5adVSvDbUI7c9EMR0ktLDyjGfGAVXF0KSk9z7BgcRn2ucpCvA50PWlToCMM8m5Hr72UHYGI7sr0om3SGxweIpnTE8TsqlgyHt9nrqcDAD2XVPGmKV7uQ0TIWWiChVe70ryAE8t49WI0gmEWS20Mc5VfIbOB84fmy3eyiuAWJNISjF6xXF5phti6Ze4Xz0k3sgDS+pWYmCuHNL5sde1A=='
            ],
            [
                ['data' => ['test' => 1]],
                'wWImA3n2RkUMZyQJL9CH86htz20ykU7NLLJT2sMYHcZgFu7CZriLpcdeQXL9IuikrpweogEuBrobmKezxn3++8aik6PDX4m21cYv50yxKRmPwrVN3t8IrHNchXNS6yDEFlhxqrJMXyBMOV/Dr2f0EoBpJCCe8NXxWlzrDo0H0YnfbBA4OhzGnSbX3Kzd0tcqLI/v8UllmwGYxAoryV3mpHAx5XsTLW3ws1imx5u97AL5UP+3V/iOOqeAj/+Yp/GnWpV3f/OdwSeddGRBvyGnMW8xhuIJgR451MrMqyNA0qb3V0MqEpu1Ifoenuc7itHGjGrA3Bq0VLzuen3t6YsBDw=='
            ],
            [
                [],
                's1GWi/DHYst+lwhma6xxuIldmy5TY/z4y60uB/FcjWvuap23yxpjH2GXZEjS6RWuZxiCvdI7aLPIGnyqHYo9atTSR2td+bzePjsAzOZ2Dj1YU31oIGVZTACQUjMgrt7OLvaH92OGdff/S1A85VitHts1hTIggb8BfjI/fNfMceQjyZ9ymIRaMPUtiNAdy69g9iEXfsmH90/GhRLOCSlykXNKp0bEWtzQdTBaCUHey9OGkurbw5C6/QCB+9qvOWbbyym16bIsL0GRD18pVsS3DDrQbnvA1y/ANxeS5hNheEbozS2qud45OWzdpGSy9nDxpYpDGaqkyve4VYZ0D5s5ww=='
            ]
        ];
    }

    /**
     * @param mixed $data
     * @param  $fixture
     * @dataProvider getSignatureDataProvider
     */
    public function testRsaGetSignature($data, $fixture) {
        $signer = new RsaSigner($this->privateKey, $this->passphrase);
        $signature = $signer->getSignature($data);
        $this->assertEquals($fixture, $signature);
    }

    private function getPrivateKey()
    {
        return "-----BEGIN ENCRYPTED PRIVATE KEY-----
MIIFHDBOBgkqhkiG9w0BBQ0wQTApBgkqhkiG9w0BBQwwHAQIzzRTosJxOcACAggA
MAwGCCqGSIb3DQIJBQAwFAYIKoZIhvcNAwcECNZf7ll0MSbvBIIEyP0oM89tBDS2
1WeNGpYpUsq3JsRVzR+KyBVNJFltp59SYcmsa0r0RKGbtDE2GUUie2ouhpNOS0Tn
N2v/nUdcOAabJuP2QZH1FM6+wItjw80Fax45VZHsUCEDAI2k0LFnFEhOegjXNwbO
hYjYrRIHXa4Wc8WRcIOsaD8KQtSqfS40/I6SjogbcxoIpE+f725gJjfnsGxb5nQT
W8+i7anIL+fZXldNigdjQh6rKL/+DsnYqA1A0SPF0vb1WCPBXTpx0fveq7azX4xZ
rS9k0KA3dzmCrQgTM9xodBQ0AfB39jOoteiCIFHlucQBz7puOrRyqJ/Ow2doXNa8
4A/YK55gboxbjwxAAISdV6Ai894V76101HxIaI5adbDXuEGu3H6uQ2TI561UNtBf
+FCLQ5+IJuSsOPKHsmS52ugb5cYd5bEP7N9XhMkKkyS7AvArwA+iF3wMTtLQhAGB
0UaJV3yWV66OqPWcGZ9Pgy5xt6QAAxFlqaba5TjZsNeWvWD1Z1L4eqpxIkI/Zb5/
kXDtkQN+12LaJQQliljkK/XE7IouebdaX+RGZKTr2IXCDslnPi/0Z1savu63fm6D
aU5fjtAMfC845tJVpIzLWIR4kORcNqzBkAqB+upE6TygMSQLX6tczMNRy8pdHoLq
vgN0Powf2P6c+ytPsQphOSbglNOOZIR1nqPVOatlLrWO0P/WfxLuZxExvoLyDmgo
EctusL8492JzqoLwgOwolnDm01wWgHOCJrdNkwh7Ec5cZ62O8TQ/vnmSyyXlNwAz
YDaZpUQz7q+eSyex02UIQgAdFhd4yUxQsN8eZ6iVohfzfAtlWbmu4UJJz2nmhZDL
cR+1+ks4ckI8AKhwXQy8L5440/xZT0LeMyefuX152hAerX0I6h1ReLpUnstICXA7
ZNAzzQ2J8Ehja4HYK+H6hyXscmk5Eav51ko0oYfeq24vlS0KND+9E26IPGsEWRKX
jObWZToQT6RenFLr4JFwbB4f1WmageSzf2kSgakwtrqpt2e5ggEEuUyan4/a9EX/
P+Jrz/Tugt3OhX91goX6045+qOZDJaAtjUwRthv7R0SkmjVcDP73yLr3DdC7zRLB
lufg/4gzGaMUf7KwkeJecyVDC/9YlBk5kh5jGtxDTPnXsv5KUu40De5k+lQWJ+Uj
O5O89tZNwQp+Mzmwkbj691yoDJf5iF4uJFBQNwDRySG2QlJ0jmQtrGzJsWRJoxWQ
TdYsZwOdfJhCYsycVM389+eYo7Q7vrzzbgqhRSUfqYEAAa+LawF+wRmItZWyup7M
T47T9Cs4TYjERvV+vhebbXlZTRLXO+5DFd7u1XIyFpMHUaVolrX33TCMZCzx1+Yl
vuQEfEv1fTPrxHI8WiuG5ZYZoJKh/AXeFpevZiPw4aMPnAtR9AQyFgv8KlnVGplG
KDafKuzJdX+e0qFKsJIzaUVuHpqM38CPblPrwgzOlzJcXfkLb2lqBy1CaOvLP7Dm
YeFbEXEATLLPlbluLHZtBtXX5kAQO0mKZyNhoNtzyKmyVqHsq28z4hEMROjrb51C
OnE3PqWxBcZHMepM4wXMbucsTQTf6vgDpefmhWvSUJTQhXeowOY2zkswREixwBtQ
+/xWL3a5ZfEBecnoqYv7TQ==
-----END ENCRYPTED PRIVATE KEY-----";
    }
}
