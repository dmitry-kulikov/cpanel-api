<?php

namespace kdn\cpanel\api;

use kdn\cpanel\api\mocks\ApiMock;
use kdn\cpanel\api\mocks\ObjectMock;

/**
 * Class ApiTest.
 * @package kdn\cpanel\api
 * @uses kdn\cpanel\api\ArrayHelper
 * @uses kdn\cpanel\api\Object
 * @uses kdn\cpanel\api\ServiceLocator
 * @uses kdn\cpanel\api\Cpanel
 */
class ApiTest extends TestCase
{
    /**
     * @var ApiMock
     */
    protected $api;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $className = ObjectMock::className();
        $this->api = new ApiMock(
            [
                'cpanel' => new Cpanel,
                'definitions' => [
                    'objectMock' => $className,
                    'objectMockWithCpanel' => ['class' => $className, 'cpanel' => null],
                ],
            ]
        );
    }

    /**
     * @covers kdn\cpanel\api\Api::get
     * @small
     */
    public function testGetCustomServiceWithoutCpanel()
    {
        $this->assertInstanceOf(ObjectMock::className(), $this->api->{'objectMock'});
        $this->assertObjectNotHasAttribute('cpanel', $this->api->{'objectMock'});
    }

    /**
     * @covers kdn\cpanel\api\Api::get
     * @small
     */
    public function testGetCustomServiceWithCpanel()
    {
        $this->assertInstanceOf(ObjectMock::className(), $this->api->{'objectMockWithCpanel'});
        $this->assertSame($this->api->cpanel, $this->api->{'objectMockWithCpanel'}->cpanel);
    }
}
