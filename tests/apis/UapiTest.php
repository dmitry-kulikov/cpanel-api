<?php

namespace kdn\cpanel\api\apis;

use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\modules\uapi\Backup;
use kdn\cpanel\api\modules\uapi\Bandwidth;
use kdn\cpanel\api\modules\uapi\Brand;
use kdn\cpanel\api\TestCase;

/**
 * Class UapiTest.
 * @package kdn\cpanel\api
 * @uses kdn\cpanel\api\Object
 * @uses kdn\cpanel\api\ServiceLocator
 * @uses kdn\cpanel\api\Cpanel
 */
class UapiTest extends TestCase
{
    /**
     * @var Uapi
     */
    protected $uapi;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->uapi = new Uapi(['cpanel' => new Cpanel]);
    }

    /**
     * @covers kdn\cpanel\api\apis\Uapi::getDefaultDefinitions
     * @small
     */
    public function testGetDefaultDefinitions()
    {
        $this->assertEquals(
            [
                'backup' => Backup::className(),
                'bandwidth' => Bandwidth::className(),
                'brand' => Brand::className(),
            ],
            $this->uapi->getDefaultDefinitions()
        );
    }

    public function getProvider()
    {
        return [
            'backup' => ['backup', Backup::className()],
            'bandwidth' => ['bandwidth', Bandwidth::className()],
            'brand' => ['brand', Brand::className()],
        ];
    }

    /**
     * @param string $service
     * @param string $class
     * @covers       kdn\cpanel\api\apis\Uapi::get
     * @uses         kdn\cpanel\api\apis\Uapi::getDefaultDefinitions
     * @dataProvider getProvider
     * @small
     */
    public function testGet($service, $class)
    {
        $this->assertInstanceOf($class, $this->uapi->$service);
        $this->assertSame($this->uapi->cpanel, $this->uapi->$service->cpanel);
    }
}
