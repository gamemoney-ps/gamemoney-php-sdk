<?php
namespace tests\CallbackHandler;

use Gamemoney\CallbackHandler\BaseCallbackHandler;
use Gamemoney\Config;
use Gamemoney\Sign\SignatureVerifierInterface;
use PHPUnit\Framework\TestCase;

class CallbackHandlerTest extends TestCase
{
    /** @var Config */
    private $config;

    protected function setUp()
    {
        $project = 1;
        $hmacKey = 'test';
        $privateKey = '123';

        $this->config = new Config($project, $hmacKey, $privateKey);
    }

    public function testConstruct()
    {
        $handler = $this->createPartialMock(BaseCallbackHandler::class, [
            'setSignatureVerifier',
        ]);

        $handler
            ->expects($this->once())
            ->method('setSignatureVerifier')
            ->with($this->isInstanceOf(SignatureVerifierInterface::class))
            ->will($this->returnSelf());

        $handler->__construct($this->config);
    }

    public function testCheck()
    {
        $result = true;
        $data = [];

        $mockVerifier = $this->createPartialMock(SignatureVerifierInterface::class, [
            'verify',
        ]);

        $mockVerifier
            ->expects($this->once())
            ->method('verify')
            ->with($data)
            ->willReturn($result);

        $handler = new BaseCallbackHandler($this->config);
        $handler->setSignatureVerifier($mockVerifier);
        $this->assertEquals($result, $handler->check($data));
    }

    public function testSuccessAnswer()
    {
        $result = '{"success":"true"}';

        $handler = new BaseCallbackHandler($this->config);
        $this->assertEquals($result, $handler->successAnswer());
    }

    /**
     * @return array
     */
    public function errorDataProvider()
    {
        return [
            [
                'error' => null,
                'output' => '{"success":"error"}'
            ],
            [
                'error' => 'message',
                'output' => '{"success":"error","error":"message"}'
            ],
        ];
    }

    /**
     * @dataProvider errorDataProvider
     * @param string|null $error
     * @param string $output
     */
    public function testErrorAnswer($error, $output)
    {
        $handler = new BaseCallbackHandler($this->config);
        $this->assertEquals($output, $handler->errorAnswer($error));
    }
}
