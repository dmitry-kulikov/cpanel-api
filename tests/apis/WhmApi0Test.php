<?php

namespace kdn\cpanel\api\apis;

use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\modules\whmApi0\ServerInformation;
use kdn\cpanel\api\TestCase;

/**
 * Class WhmApi0Test.
 * @package kdn\cpanel\api
 * @uses kdn\cpanel\api\Object
 * @uses kdn\cpanel\api\ServiceLocator
 * @uses kdn\cpanel\api\Cpanel
 */
class WhmApi0Test extends TestCase
{
    /**
     * @var WhmApi0
     */
    protected $whmApi0;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->whmApi0 = new WhmApi0(['cpanel' => new Cpanel]);
    }

    /**
     * @covers kdn\cpanel\api\apis\WhmApi0::getDefaultDefinitions
     * @small
     */
    public function testGetDefaultDefinitions()
    {
        $this->assertEquals(
            [
                'serverInformation' => ServerInformation::className(),
            ],
            $this->whmApi0->getDefaultDefinitions()
        );
    }

    public function getProvider()
    {
        return [
            'serverInformation' => ['serverInformation', ServerInformation::className()],
        ];
    }

    /**
     * @param string $service
     * @param string $class
     * @covers       kdn\cpanel\api\apis\WhmApi0::get
     * @uses         kdn\cpanel\api\apis\WhmApi0::getDefaultDefinitions
     * @dataProvider getProvider
     * @small
     */
    public function testGet($service, $class)
    {
        $this->assertInstanceOf($class, $this->whmApi0->$service);
        $this->assertSame($this->whmApi0->cpanel, $this->whmApi0->$service->cpanel);
    }
}
