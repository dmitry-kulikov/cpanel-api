<?php

namespace kdn\cpanel\api\modules\whmApi1;

use kdn\cpanel\api\responses\WhmApi1Response;

/**
 * Class ServerAdministration.
 * @package kdn\cpanel\api\modules\whmApi1
 * @property \kdn\cpanel\api\modules\whmApi1\ServerAdministration $module
 * @covers \kdn\cpanel\api\modules\WhmApi0Module
 * @covers \kdn\cpanel\api\modules\WhmApi1Module
 * @uses   \kdn\cpanel\api\Object
 * @uses   \kdn\cpanel\api\ServiceLocator
 * @uses   \kdn\cpanel\api\Cpanel
 * @uses   \kdn\cpanel\api\Auth
 * @uses   \kdn\cpanel\api\Api
 * @uses   \kdn\cpanel\api\apis\WhmApi1
 * @uses   \kdn\cpanel\api\Module
 * @uses   \kdn\cpanel\api\Response
 * @uses   \kdn\cpanel\api\responses\WhmApi1Response
 */
class ServerAdministrationTest extends WhmApi1ModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $moduleName = 'serverAdministration';

    /**
     * @covers \kdn\cpanel\api\modules\whmApi1\ServerAdministration::getHostName
     * @medium
     */
    public function testGetHostName()
    {
        $this->assertInstanceOf(WhmApi1Response::className(), $this->module->getHostName());
        $request = $this->getLastRequest();
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getWhmHost() . ':' . static::getWhmPort() . '/json-api/gethostname?api.version=1',
            (string)$request->getUri()
        );
    }
}
