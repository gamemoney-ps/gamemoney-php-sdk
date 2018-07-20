<?php
namespace tests;

use Gamemoney\Validation\Rules\DefaultRules;
use PHPUnit\Framework\TestCase;
use Gamemoney\Gateway;
use Gamemoney\Request\RequestInterface;
use Gamemoney\Send\SenderInterface;
use Gamemoney\Exception\ConfigException;
use Gamemoney\Validation\ValidatorInterface;
use Gamemoney\Validation\RulesResolverInterface;

class GatewayTest extends TestCase
{
    private $config;

    protected function setUp()
    {
        $this->config = [
            'privateKey' => "123",
            'hmacKey' => 'test',
            'project' => 1,
        ];
    }

    public function configDataProvider()
    {
        return [
            [
                []
            ],
            [
                [
                    'project' => 1
                ]
            ],
            [
                [
                    'project' => 1,
                    'hmacKey' => 'test',
                ]
            ],
        ];
    }

    /**
     * @dataProvider configDataProvider
     * @param $config
     */
    public function testConstructConfigWrong($config)
    {
        $this->expectException(ConfigException::class);
        $gateway = new Gateway($config);
    }


    public function testSend()
    {
        $mockRequest = $this->getRequestMock();

        $mockRequest
            ->expects($this->once())
            ->method('setField')
            ->with('project', 1);

        $mockRulesResolver = $this
            ->getMockBuilder(RulesResolverInterface::class)
            ->setMethods(['resolve'])
            ->getMock();

        $mockRulesResolver
            ->expects($this->once())
            ->method('resolve')
            ->willReturn(new DefaultRules());

        $mockSender = $this
            ->getMockBuilder(SenderInterface::class)
            ->setMethods(['send'])
            ->getMock();

        $mockSender
            ->expects($this->once())
            ->method('send')
            ->with($mockRequest)
            ->willReturn(['success' => 'true']);

        $mockValidator = $this
            ->getMockBuilder(ValidatorInterface::class)
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->willReturn(null);



        $gateway = (new Gateway($this->config))
            ->setSender($mockSender)
            ->setValidator($mockValidator)
            ->setRulesResolver($mockRulesResolver);

        $response = $gateway->send($mockRequest);
        $this->assertEquals(['success' => 'true'], $response);
    }

    private function getRequestMock()
    {
        $mockRequest = $this
            ->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['getData', 'getAction', 'setData', 'setAction', 'getField', 'setField'])
            ->getMock();

        $mockRequest
            ->method('getData')
            ->willReturn(['data' => ['test' => 1]]);

        return $mockRequest;
    }

    public function testConstuctMethod()
    {
        $gateway = $this->createMock(Gateway::class, ['setValidator', 'setRulesResolver', 'setSender']);
        $gateway
            ->expects($this->once())
            ->method('setValidator')
            ->with($this->isInstanceOf(ValidatorInterface::class))
            ->will($this->returnSelf());
        $gateway
            ->expects($this->once())
            ->method('setRulesResolver')
            ->with($this->isInstanceOf(RulesResolverInterface::class))
            ->will($this->returnSelf());
        $gateway
            ->expects($this->once())
            ->method('setSender')
            ->with($this->isInstanceOf(SenderInterface::class))
            ->will($this->returnSelf());
        $gateway->__construct($this->config);
    }
}