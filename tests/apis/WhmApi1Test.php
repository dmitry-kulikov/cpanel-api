<?php

namespace kdn\cpanel\api;

use kdn\cpanel\api\apis\WhmApi1;
use kdn\cpanel\api\modules\whmApi1\ServerInformation;

/**
 * Class WhmApi1Test.
 * @package kdn\cpanel\api
 * @uses kdn\cpanel\api\Object
 * @uses kdn\cpanel\api\ServiceLocator
 * @uses kdn\cpanel\api\Cpanel
 */
class WhmApi1Test extends TestCase
{
    /**
     * @var WhmApi1
     */
    protected $whmApi1;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->whmApi1 = new WhmApi1(['cpanel' => new Cpanel]);
    }

    /**
     * @covers kdn\cpanel\api\apis\WhmApi1::getDefaultDefinitions
     * @small
     */
    public function testGetDefaultDefinitions()
    {
        $this->assertEquals(
            [
                'serverInformation' => ServerInformation::className(),
            ],
            $this->whmApi1->getDefaultDefinitions()
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
     * @covers       kdn\cpanel\api\Api::get
     * @uses         kdn\cpanel\api\apis\WhmApi1::getDefaultDefinitions
     * @dataProvider getProvider
     * @small
     */
    public function testGet($service, $class)
    {
        $this->assertInstanceOf($class, $this->whmApi1->$service);
        $this->assertSame($this->whmApi1->cpanel, $this->whmApi1->$service->cpanel);
    }
}
