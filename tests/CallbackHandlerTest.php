<?php
namespace tests;

use Gamemoney\CallbackHandler\InvoiceCallbackHandler;
use Gamemoney\Exception\ConfigException;
use Gamemoney\Sign\SignatureVerifierInterface;
use PHPUnit\Framework\TestCase;

class CallbackHandlerTest extends TestCase
{
    private $config = [
        'apiPublicKey' => '123'
    ];

    public function testConstruct()
    {
        $handler = $this->createPartialMock(InvoiceCallbackHandler::class, [
            'setSignatureVerifier',
        ]);

        $handler
            ->expects($this->once())
            ->method('setSignatureVerifier')
            ->with($this->isInstanceOf(SignatureVerifierInterface::class))
            ->will($this->returnSelf());

        $handler->__construct($this->config);
    }

    public function testConstructConfigWrong()
    {
        $this->expectException(ConfigException::class);
        new InvoiceCallbackHandler([]);
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

        $handler = new InvoiceCallbackHandler($this->config);
        $handler->setSignatureVerifier($mockVerifier);
        $this->assertEquals($result, $handler->check($data));
    }

    public function testSuccessAnswer()
    {
        $result = '{"success":"true"}';

        $handler = new InvoiceCallbackHandler($this->config);
        $this->assertEquals($result, $handler->successAnswer());
    }

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
        $handler = new InvoiceCallbackHandler($this->config);
        $this->assertEquals($output, $handler->errorAnswer($error));
    }


}
