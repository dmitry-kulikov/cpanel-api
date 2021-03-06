<?php

namespace kdn\cpanel\api\modules\uapi;

use kdn\cpanel\api\responses\UapiResponse;

/**
 * Class BrandTest.
 * @package kdn\cpanel\api\modules\uapi
 * @property \kdn\cpanel\api\modules\uapi\Brand $module
 * @covers \kdn\cpanel\api\modules\UapiModule
 * @uses   \kdn\cpanel\api\Object
 * @uses   \kdn\cpanel\api\ServiceLocator
 * @uses   \kdn\cpanel\api\Cpanel
 * @uses   \kdn\cpanel\api\Auth
 * @uses   \kdn\cpanel\api\Api
 * @uses   \kdn\cpanel\api\apis\Uapi
 * @uses   \kdn\cpanel\api\Module
 * @uses   \kdn\cpanel\api\Response
 * @uses   \kdn\cpanel\api\responses\UapiResponse
 */
class BrandTest extends UapiModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $moduleName = 'brand';

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Brand::read
     * @medium
     */
    public function testRead()
    {
        $this->assertInstanceOf(UapiResponse::className(), $this->module->read());
        $request = $this->getLastRequest();
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':' . static::getCpanelPort() . '/execute/Brand/read',
            (string)$request->getUri()
        );
    }
}
