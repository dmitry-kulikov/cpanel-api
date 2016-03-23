<?php

namespace kdn\cpanel\api;

use kdn\cpanel\api\apis\Api2;
use kdn\cpanel\api\apis\Uapi;
use kdn\cpanel\api\apis\WhmApi0;
use kdn\cpanel\api\apis\WhmApi1;
use kdn\cpanel\api\mocks\ObjectMock;

/**
 * Class CpanelTest.
 * @package kdn\cpanel\api
 * @uses kdn\cpanel\api\ArrayHelper
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
        $className = ObjectMock::className();
        $this->cpanel = new Cpanel(
            [
                'definitions' => [
                    'objectMock' => $className,
                    'objectMockWithCpanel' => ['class' => $className, 'cpanel' => null],
                ],
            ]
        );
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
     * @uses         kdn\cpanel\api\apis\Api2::getDefaultDefinitions
     * @uses         kdn\cpanel\api\apis\Uapi::getDefaultDefinitions
     * @uses         kdn\cpanel\api\apis\WhmApi0::getDefaultDefinitions
     * @uses         kdn\cpanel\api\apis\WhmApi1::getDefaultDefinitions
     * @dataProvider getProvider
     * @small
     */
    public function testGet($service, $class)
    {
        $this->assertInstanceOf($class, $this->cpanel->$service);
        $this->assertSame($this->cpanel, $this->cpanel->$service->cpanel);
    }

    /**
     * @covers kdn\cpanel\api\Cpanel::get
     * @uses   kdn\cpanel\api\Cpanel::getDefaultDefinitions
     * @small
     */
    public function testGetCustomServiceWithoutCpanel()
    {
        $this->assertInstanceOf(ObjectMock::className(), $this->cpanel->{'objectMock'});
        $this->assertObjectNotHasAttribute('cpanel', $this->cpanel->{'objectMock'});
    }

    /**
     * @covers kdn\cpanel\api\Cpanel::get
     * @uses   kdn\cpanel\api\Cpanel::getDefaultDefinitions
     * @small
     */
    public function testGetCustomServiceWithCpanel()
    {
        $this->assertInstanceOf(ObjectMock::className(), $this->cpanel->{'objectMockWithCpanel'});
        $this->assertSame($this->cpanel, $this->cpanel->{'objectMockWithCpanel'}->cpanel);
    }
}
