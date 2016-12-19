<?php

namespace kdn\cpanel\api\modules\uapi;

use kdn\cpanel\api\responses\UapiResponse;

/**
 * Class MysqlTest.
 * @package kdn\cpanel\api\modules\uapi
 * @property \kdn\cpanel\api\modules\uapi\Mysql $module
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
class MysqlTest extends DatabaseModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $moduleName = 'mysql';

    /**
     * @inheritdoc
     */
    protected $apiModuleName = 'Mysql';

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Mysql::deleteUser
     * @medium
     */
    public function testDeleteUser()
    {
        $this->assertInstanceOf(UapiResponse::className(), $this->module->deleteUser($this->userName));
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() .
            ":2083/execute/$this->apiModuleName/delete_user?name=$this->userName",
            (string)$request->getUri()
        );
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Mysql::renameUser
     * @medium
     */
    public function testRenameUser()
    {
        $newName = $this->userName . '_new';
        $this->assertInstanceOf(UapiResponse::className(), $this->module->renameUser($this->userName, $newName));
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() .
            ":2083/execute/$this->apiModuleName/rename_user?oldname=$this->userName&newname=$newName",
            (string)$request->getUri()
        );
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Mysql::setPassword
     * @medium
     */
    public function testSetPassword()
    {
        $newPassword = 'new_password';
        $this->assertInstanceOf(UapiResponse::className(), $this->module->setPassword($this->userName, $newPassword));
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() .
            ":2083/execute/$this->apiModuleName/set_password?user=$this->userName&password=$newPassword",
            (string)$request->getUri()
        );
    }
}
