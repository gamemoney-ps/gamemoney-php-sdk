<?php

namespace mesosdns\tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use mesosdns\MesosDns;
use mesosdns\Service;
use mesosdns\ServiceInstance;
use mesosdns\Method\ApiMethod;
use mesosdns\Method\DnsMethod;
use mesosdns\Exception\NotFoundMethodException;

class ApiMethodTest extends TestCase {

    public $fixtureUrl;
    public $fixtureResponse;

    protected function setUp()
    {
        $this->fixtureUrl = 'http://test.test:8123/v1/';
        $this->fixtureResponse = [
            [
                "service" => "test.test._tcp.marathon.mesos",
                "host" => "test.test-xggn5-s0.marathon.mesos.",
                "ip" => "10.10.10.10",
                "port" => "31059"
            ],
            [
                "service" => "test.test._tcp.marathon.mesos",
                "host" => "test.test-xggn5-s0.marathon.mesos.",
                "ip" => "10.10.10.10",
                "port" => "31060"
            ],
            [
                "service" => "test.test._tcp.marathon.mesos",
                "host" => "test.test-xggn6-s0.marathon.mesos.",
                "ip" => "10.10.10.11",
                "port" => "31061"
            ],
            [
                "service" => "test.test._tcp.marathon.mesos",
                "host" => "test.test-xggn6-s0.marathon.mesos.",
                "ip" => "10.10.10.11",
                "port" => "31062"
            ]
        ];
    }

    public function testConstuctor() {

        $ApiMethod = new ApiMethod($this->fixtureUrl);

        $reflectionClass = new \ReflectionClass(ApiMethod::class);
        $reflectionProperty = $reflectionClass->getProperty('client');
        $reflectionProperty->setAccessible(true);
        $client = $reflectionProperty->getValue($ApiMethod);
        $this->assertTrue($client instanceof Client);
    }

    public function testFindService() {

        $ApiMethod = new ApiMethod($this->fixtureUrl);

        $MethodStub = $this->getMockBuilder(ApiMethod::class)
            ->disableOriginalConstructor()
            ->setMethods(['getResponseAsArray'])
            ->getMock();

        $MethodStub->method('getResponseAsArray')->willReturn($this->fixtureResponse);
        $MethodStub->expects($this->once())->method('getResponseAsArray');
        $Service = $MethodStub->findService('test', 'test');

        $this->assertInstanceOf(Service::class, $Service);
        $this->assertCount(2, $Service->Instances);
    }


}
