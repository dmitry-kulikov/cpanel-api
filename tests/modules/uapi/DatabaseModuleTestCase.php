<?php

namespace kdn\cpanel\api\modules\uapi;

use kdn\cpanel\api\responses\UapiResponse;

/**
 * Class DatabaseModuleTest.
 * @package kdn\cpanel\api\modules\uapi
 * @property \kdn\cpanel\api\modules\uapi\DatabaseModule $module
 */
abstract class DatabaseModuleTestCase extends UapiModuleTestCase
{
    /**
     * @var string API module name
     */
    protected $apiModuleName;

    /**
     * @var string database name
     */
    protected $databaseName = 'test';

    /**
     * @var string user name
     */
    protected $userName = 'user';

    /**
     * @covers \kdn\cpanel\api\modules\uapi\DatabaseModule::createDatabase
     * @medium
     */
    public function testCreateDatabase()
    {
        $this->assertInstanceOf(UapiResponse::className(), $this->module->createDatabase($this->databaseName));
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() .
            ":2083/execute/$this->apiModuleName/create_database?name=$this->databaseName",
            (string)$request->getUri()
        );
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\DatabaseModule::createUser
     * @medium
     */
    public function testCreateUser()
    {
        $this->assertInstanceOf(UapiResponse::className(), $this->module->createUser($this->userName, 'password'));
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() .
            ":2083/execute/$this->apiModuleName/create_user?name=$this->userName&password=password",
            (string)$request->getUri()
        );
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\DatabaseModule::deleteDatabase
     * @medium
     */
    public function testDeleteDatabase()
    {
        $this->assertInstanceOf(UapiResponse::className(), $this->module->deleteDatabase($this->databaseName));
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() .
            ":2083/execute/$this->apiModuleName/delete_database?name=$this->databaseName",
            (string)$request->getUri()
        );
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\DatabaseModule::getRestrictions
     * @medium
     */
    public function testGetRestrictions()
    {
        $this->assertInstanceOf(UapiResponse::className(), $this->module->getRestrictions());
        $request = $this->getLastRequest();
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ":2083/execute/$this->apiModuleName/get_restrictions",
            (string)$request->getUri()
        );
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\DatabaseModule::renameDatabase
     * @medium
     */
    public function testRenameDatabase()
    {
        $newName = $this->databaseName . '_new';
        $this->assertInstanceOf(
            UapiResponse::className(),
            $this->module->renameDatabase($this->databaseName, $newName)
        );
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() .
            ":2083/execute/$this->apiModuleName/rename_database?oldname=$this->databaseName&newname=$newName",
            (string)$request->getUri()
        );
    }
}
