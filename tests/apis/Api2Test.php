<?php

namespace kdn\cpanel\api\apis;

use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\modules\api2\DnsLookup;
use kdn\cpanel\api\TestCase;

/**
 * Class Api2Test.
 * @package kdn\cpanel\api
 * @uses kdn\cpanel\api\Object
 * @uses kdn\cpanel\api\ServiceLocator
 * @uses kdn\cpanel\api\Cpanel
 */
class Api2Test extends TestCase
{
    /**
     * @var Api2
     */
    protected $api2;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->api2 = new Api2(['cpanel' => new Cpanel]);
    }

    /**
     * @covers kdn\cpanel\api\apis\Api2::getDefaultDefinitions
     * @small
     */
    public function testGetDefaultDefinitions()
    {
        $this->assertEquals(
            [
                'dnsLookup' => DnsLookup::className(),
            ],
            $this->api2->getDefaultDefinitions()
        );
    }

    public function getProvider()
    {
        return [
            'dnsLookup' => ['dnsLookup', DnsLookup::className()],
        ];
    }

    /**
     * @param string $service
     * @param string $class
     * @covers       kdn\cpanel\api\apis\Api2::get
     * @uses         kdn\cpanel\api\apis\Api2::getDefaultDefinitions
     * @dataProvider getProvider
     * @small
     */
    public function testGet($service, $class)
    {
        $this->assertInstanceOf($class, $this->api2->$service);
        $this->assertSame($this->api2->cpanel, $this->api2->$service->cpanel);
    }
}
