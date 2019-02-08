<?php
namespace tests\Sign;

use Gamemoney\Exception\SignatureVerificationException;
use Gamemoney\Sign\SignatureVerifier;
use phpmock\phpunit\PHPMock;
use PHPUnit\Framework\TestCase;

class SignatureVerifierErrorTest extends TestCase
{
    use PHPMock;

    public function testVerificationError()
    {
        $key = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAq/P7DCmQkzfJDs9014in
I1CMXWTZpQtpkFF10YOpOKTwnHr3nXg4/8WNvZmNY/0ArWRh6cBwucktds0bherd
TH9wgdlTgLfjIGuBX/h4W6ykqfm+O/cUtXrOgpqufOXvEVv5tUjXEKPCOFp8Xbyc
/9/+SP9JXk+o9NFYHkfK8kPUQEk0yxMBKl6YxKAlhGG0vKzgc2aCgD7jGTgafWft
pjCBKsR3apwx/K4J2N+X+XUFwTb8vHvd0kAHh+oZQ3f31kB5LBxat9GqFrfWXYva
JdApdbXXHhrDoSP3D8YaYmbL4TX04egOWT28gD0uvlT4h7ggKk0hYlMcjs30lGP4
/QIDAQAB
-----END PUBLIC KEY-----';

        $signature = 'QSqpJLZLwJTqEMzZ1Y7JXO3Xi9Fiymyn3j4c1r5Ip/dbsG3VIxp16eQU2IsVkmB97BAbfdSVW3k7Fgx0zM1QA8CikFBAr8nffE
        IMtOGulTJX2N4zWg4JcK5OwYoC5HodnW2/p8lUuLMZjmaogsqlRGuFUU+PRPg3S8fQDRZjNfabRT9CiPJfwx24LUaxtXXyxMOXLYqhDco2SSyNwU
        SmETcJdxVKYjB9T40GcsoSCb1T7a95VZxPsOvcHOMMd7MFN5LqfU2YQqDy+gctvpXWSjIzUmHqYfn8ljDBt0B0Oz+SB4xIDIIrfiFM/wPWfKFmTO
        HIo8PycTiyiJDw+M3krg==';

        $this
            ->getFunctionMock('Gamemoney\Sign', 'openssl_verify')
            ->expects($this->once())->willReturn(-1);

        $this->expectException(SignatureVerificationException::class);

        (new SignatureVerifier($key))->verify(['signature' => $signature]);
    }
}
