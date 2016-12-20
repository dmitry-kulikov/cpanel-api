<?php

namespace kdn\cpanel\api\modules\whmApi0;

use kdn\cpanel\api\responses\WhmApi0Response;

/**
 * Class ServerAdministration.
 * @package kdn\cpanel\api\modules\whmApi0
 * @property \kdn\cpanel\api\modules\whmApi0\ServerAdministration $module
 * @covers \kdn\cpanel\api\modules\WhmApi0Module
 * @uses   \kdn\cpanel\api\Object
 * @uses   \kdn\cpanel\api\ServiceLocator
 * @uses   \kdn\cpanel\api\Cpanel
 * @uses   \kdn\cpanel\api\Auth
 * @uses   \kdn\cpanel\api\Api
 * @uses   \kdn\cpanel\api\apis\WhmApi0
 * @uses   \kdn\cpanel\api\Module
 * @uses   \kdn\cpanel\api\Response
 * @uses   \kdn\cpanel\api\responses\WhmApi0Response
 */
class ServerAdministrationTest extends WhmApi0ModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $moduleName = 'serverAdministration';

    /**
     * @covers \kdn\cpanel\api\modules\whmApi0\ServerAdministration::getHostName
     * @medium
     */
    public function testGetHostName()
    {
        $this->assertInstanceOf(WhmApi0Response::className(), $this->module->getHostName());
        $request = $this->getLastRequest();
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getWhmHost() . ':' . static::getWhmPort() . '/json-api/gethostname',
            (string)$request->getUri()
        );
    }
}
