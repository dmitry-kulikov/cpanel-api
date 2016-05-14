<?php

namespace kdn\cpanel\api\modules\uapi;

use kdn\cpanel\api\responses\UapiResponse;

/**
 * Class BatchTest.
 * @package kdn\cpanel\api\modules\uapi
 * @property \kdn\cpanel\api\modules\uapi\Batch $module
 * @covers kdn\cpanel\api\modules\UapiModule
 * @uses   kdn\cpanel\api\Object
 * @uses   kdn\cpanel\api\ServiceLocator
 * @uses   kdn\cpanel\api\Cpanel
 * @uses   kdn\cpanel\api\Auth
 * @uses   kdn\cpanel\api\Api
 * @uses   kdn\cpanel\api\apis\Uapi
 * @uses   kdn\cpanel\api\Module
 * @uses   kdn\cpanel\api\Response
 * @uses   kdn\cpanel\api\responses\UapiResponse
 */
class BatchTest extends UapiModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $moduleName = 'batch';

    /**
     * @covers kdn\cpanel\api\modules\uapi\Batch::strict
     * @medium
     */
    public function testStrictSingleCommand()
    {
        $response = $this->module->strict('["PasswdStrength","get_required_strength",{"app":"webdisk"}]');
        $this->assertInstanceOf(UapiResponse::className(), $response);
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':2083/execute/Batch/strict?' .
            'command-0=%5B%22PasswdStrength%22%2C%22get_required_strength%22%2C%7B%22app%22%3A%22webdisk%22%7D%5D',
            (string)$request->getUri()
        );
    }

    /**
     * @covers kdn\cpanel\api\modules\uapi\Batch::strict
     * @medium
     */
    public function testStrictMultipleCommands()
    {
        $response = $this->module->strict(
            [
                'command-1' => '["PasswdStrength","get_required_strength",{"app":"webdisk"}]',
                'command-0' => '["SSH","get_port",{}]',
            ]
        );
        $this->assertInstanceOf(UapiResponse::className(), $response);
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':2083/execute/Batch/strict?' .
            'command-0=%5B%22SSH%22%2C%22get_port%22%2C%7B%7D%5D&' .
            'command-1=%5B%22PasswdStrength%22%2C%22get_required_strength%22%2C%7B%22app%22%3A%22webdisk%22%7D%5D',
            (string)$request->getUri()
        );
    }

    /**
     * @covers kdn\cpanel\api\modules\uapi\Batch::strict
     * @medium
     */
    public function testStrictMultipleCommandsImplicitOrder()
    {
        $response = $this->module->strict(
            [
                '["PasswdStrength","get_required_strength",{"app":"webdisk"}]',
                '["SSH","get_port",{}]',
            ]
        );
        $this->assertInstanceOf(UapiResponse::className(), $response);
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':2083/execute/Batch/strict?' .
            'command-0=%5B%22PasswdStrength%22%2C%22get_required_strength%22%2C%7B%22app%22%3A%22webdisk%22%7D%5D&' .
            'command-1=%5B%22SSH%22%2C%22get_port%22%2C%7B%7D%5D',
            (string)$request->getUri()
        );
    }
}
