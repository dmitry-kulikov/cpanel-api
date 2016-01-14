<?php

namespace kdn\cpanel\api;

/**
 * Class CpanelTest.
 * @package kdn\cpanel\api
 * @uses kdn\cpanel\api\Object
 * @uses kdn\cpanel\api\ServiceLocator
 */
class CpanelTest extends TestCase
{
    /**
     * @var Cpanel
     */
    protected $cpanel;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->cpanel = new Cpanel;
    }

    /**
     * @covers kdn\cpanel\api\Cpanel::getDefaultDefinitions
     * @small
     */
    public function testGetDefaultDefinitions()
    {
        $this->assertEquals(
            [
                Cpanel::API_2 => Api2::className(),
                Cpanel::UAPI => Uapi::className(),
                Cpanel::WHM_API_0 => WhmApi0::className(),
                Cpanel::WHM_API_1 => WhmApi1::className(),
            ],
            $this->cpanel->getDefaultDefinitions()
        );
    }

    public function getProvider()
    {
        return [
            Cpanel::API_2 => [Cpanel::API_2, Api2::className()],
            Cpanel::UAPI => [Cpanel::UAPI, Uapi::className()],
            Cpanel::WHM_API_0 => [Cpanel::WHM_API_0, WhmApi0::className()],
            Cpanel::WHM_API_1 => [Cpanel::WHM_API_1, WhmApi1::className()],
        ];
    }

    /**
     * @param string $service
     * @param string $class
     * @covers       kdn\cpanel\api\Cpanel::get
     * @uses         kdn\cpanel\api\Cpanel::getDefaultDefinitions
     * @uses         kdn\cpanel\api\Api2::getDefaultDefinitions
     * @uses         kdn\cpanel\api\Uapi::getDefaultDefinitions
     * @uses         kdn\cpanel\api\WhmApi0::getDefaultDefinitions
     * @uses         kdn\cpanel\api\WhmApi1::getDefaultDefinitions
     * @dataProvider getProvider
     * @small
     */
    public function testGet($service, $class)
    {
        $this->assertInstanceOf($class, $this->cpanel->$service);
        $this->assertSame($this->cpanel, $this->cpanel->$service->cpanel);
    }
}
