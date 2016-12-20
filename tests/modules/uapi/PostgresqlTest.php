<?php

namespace kdn\cpanel\api\modules\uapi;

use kdn\cpanel\api\responses\UapiResponse;

/**
 * Class PostgresqlTest.
 * @package kdn\cpanel\api\modules\uapi
 * @property \kdn\cpanel\api\modules\uapi\Postgresql $module
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
class PostgresqlTest extends DatabaseModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $moduleName = 'postgresql';

    /**
     * @inheritdoc
     */
    protected $apiModuleName = 'Postgresql';

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Postgresql::renameUser
     * @medium
     */
    public function testRenameUser()
    {
        $newName = $this->userName . '_new';
        $this->assertInstanceOf(
            UapiResponse::className(),
            $this->module->renameUser($this->userName, $newName, 'password')
        );
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':' . static::getCpanelPort() .
            "/execute/$this->apiModuleName/rename_user?oldname=$this->userName&newname=$newName&password=password",
            (string)$request->getUri()
        );
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Postgresql::renameUserNoPassword
     * @medium
     */
    public function testRenameUserNoPassword()
    {
        $newName = $this->userName . '_new';
        $this->assertInstanceOf(
            UapiResponse::className(),
            $this->module->renameUserNoPassword($this->userName, $newName)
        );
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':' . static::getCpanelPort() .
            "/execute/$this->apiModuleName/rename_user_no_password?oldname=$this->userName&newname=$newName",
            (string)$request->getUri()
        );
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Postgresql::setPassword
     * @medium
     */
    public function testSetPassword()
    {
        $newPassword = 'new_password';
        $this->assertInstanceOf(UapiResponse::className(), $this->module->setPassword($this->userName, $newPassword));
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':' . static::getCpanelPort() .
            "/execute/$this->apiModuleName/set_password?name=$this->userName&password=$newPassword",
            (string)$request->getUri()
        );
    }
}
