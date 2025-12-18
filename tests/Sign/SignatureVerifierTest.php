<?php

namespace tests\Sign;

use Gamemoney\Sign\SignatureVerifier;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SignatureVerifierTest extends TestCase
{
    public static function verifyProvider(): array
    {
        return [
            [
                'data' => [
                    'time' => 1533659583,
                    'rand' => '6336694fe808a1ec1443',
                    'success' => true,
                    'signature' => 'QSqpJLZLwJTqEMzZ1Y7JXO3Xi9Fiymyn3j4c1r5Ip/dbsG3VIxp16eQU2IsVkmB97BAbfdSVW3k7Fgx0zM1Q
                    A8CikFBAr8nffEIMtOGulTJX2N4zWg4JcK5OwYoC5HodnW2/p8lUuLMZjmaogsqlRGuFUU+PRPg3S8fQDRZjNfabRT9CiPJfwx24
                    LUaxtXXyxMOXLYqhDco2SSyNwUSmETcJdxVKYjB9T40GcsoSCb1T7a95VZxPsOvcHOMMd7MFN5LqfU2YQqDy+gctvpXWSjIzUmHq
                    Yfn8ljDBt0B0Oz+SB4xIDIIrfiFM/wPWfKFmTOHIo8PycTiyiJDw+M3krg==',
                ],
                'key' => '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAx5B70y7kaFJ8yte7dsdt
vuPYNfN2j1hJSChPuOM4oWY8uUmmGl6f33CJQ69IClWle9I3HIUm81yT3QCVnD7l
r/JYse6cI2vILIaIdvmqu6VcDaiv+O+sUbPoRxq9lxfY5GnHFSrzUBy1yDugCuAE
TM2iRnHpYHbbILDrVs9csfLEeaJ56zn5kan9qJM4ecPKPXv6OabGHK9JkROxQyya
YJPk0mrA98jGvh9/ZrZxQuvH/Kvh61SXC3cpidKkIsCyw2vr0x6A5RnGU8q9fLdW
Ua4nSr1picTSmbryCb/zVGtH4ZgNXFYl7peQu7qNOeohyQFgwAtaYeg/NEDz90nu
sQIDAQAB
-----END PUBLIC KEY-----',
                'result' => true,
            ],
            [
                'data' => [
                    'time' => 1533659583,
                    'rand' => '6336694fe808a1ec1443',
                    'success' => true,
                    'signature' => 'QSqpJLZLwJTqEMzZ1Y7JXO3Xi9Fiymyn3j4c1r5Ip/dbsG3VIxp16eQU2IsVkmB97BAbfdSVW3k7Fgx0zM1Q
                    A8CikFBAr8nffEIMtOGulTJX2N4zWg4JcK5OwYoC5HodnW2/p8lUuLMZjmaogsqlRGuFUU+PRPg3S8fQDRZjNfabRT9CiPJfwx24
                    LUaxtXXyxMOXLYqhDco2SSyNwUSmETcJdxVKYjB9T40GcsoSCb1T7a95VZxPsOvcHOMMd7MFN5LqfU2YQqDy+gctvpXWSjIzUmHq
                    Yfn8ljDBt0B0Oz+SB4xIDIIrfiFM/wPWfKFmTOHIo8PycTiyiJDw+M3krg==',
                ],
                'key' => '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAq/P7DCmQkzfJDs9014in
I1CMXWTZpQtpkFF10YOpOKTwnHr3nXg4/8WNvZmNY/0ArWRh6cBwucktds0bherd
TH9wgdlTgLfjIGuBX/h4W6ykqfm+O/cUtXrOgpqufOXvEVv5tUjXEKPCOFp8Xbyc
/9/+SP9JXk+o9NFYHkfK8kPUQEk0yxMBKl6YxKAlhGG0vKzgc2aCgD7jGTgafWft
pjCBKsR3apwx/K4J2N+X+XUFwTb8vHvd0kAHh+oZQ3f31kB5LBxat9GqFrfWXYva
JdApdbXXHhrDoSP3D8YaYmbL4TX04egOWT28gD0uvlT4h7ggKk0hYlMcjs30lGP4
/QIDAQAB
-----END PUBLIC KEY-----',
                'result' => false,
            ],
            [
                'data' => [
                    'time' => 1533659583,
                    'rand' => '6336694fe808a1ec1443',
                    'success' => true,
                ],
                'key' => '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAx5B70y7kaFJ8yte7dsdt
vuPYNfN2j1hJSChPuOM4oWY8uUmmGl6f33CJQ69IClWle9I3HIUm81yT3QCVnD7l
r/JYse6cI2vILIaIdvmqu6VcDaiv+O+sUbPoRxq9lxfY5GnHFSrzUBy1yDugCuAE
TM2iRnHpYHbbILDrVs9csfLEeaJ56zn5kan9qJM4ecPKPXv6OabGHK9JkROxQyya
YJPk0mrA98jGvh9/ZrZxQuvH/Kvh61SXC3cpidKkIsCyw2vr0x6A5RnGU8q9fLdW
Ua4nSr1picTSmbryCb/zVGtH4ZgNXFYl7peQu7qNOeohyQFgwAtaYeg/NEDz90nu
sQIDAQAB
-----END PUBLIC KEY-----',
                'result' => false,
            ],
        ];
    }

    #[DataProvider('verifyProvider')]
    public function testVerify(array $data, string $key, bool $result): void
    {
        $verifier = new SignatureVerifier($key);
        $this->assertSame($result, $verifier->verify($data));
    }
}
