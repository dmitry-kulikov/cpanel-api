<?php

namespace kdn\cpanel\api\modules;

use kdn\cpanel\api\Auth;
use kdn\cpanel\api\mocks\Api2ModuleMock;
use kdn\cpanel\api\TestCase;

/**
 * Class Api2ModuleTest.
 * @package kdn\cpanel\api\modules
 * @uses \kdn\cpanel\api\Object
 * @uses \kdn\cpanel\api\Auth
 * @uses \kdn\cpanel\api\Module
 */
class Api2ModuleTest extends TestCase
{
    /**
     * @var Api2ModuleMock
     */
    protected $module;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->module = new Api2ModuleMock();
    }

    /**
     * @covers \kdn\cpanel\api\modules\Api2Module::getTargetUsername
     * @covers \kdn\cpanel\api\modules\Api2Module::setTargetUsername
     * @small
     */
    public function testSetTargetUsernameAndGetTargetUsername()
    {
        $targetUsername = 'user';
        $this->assertEquals($targetUsername, $this->module->setTargetUsername($targetUsername)->getTargetUsername());
    }

    /**
     * @covers \kdn\cpanel\api\modules\Api2Module::buildUri
     * @uses   \kdn\cpanel\api\modules\Api2Module::getTargetUsername
     * @expectedException \kdn\cpanel\api\exceptions\Exception
     * @expectedExceptionMessage Target username must be specified.
     * @small
     */
    public function testTargetUsernameNotSpecifiedException()
    {
        $this->module->setAuth(new Auth(['hash' => static::getCpanelAuthHash()]))->send('get', 'read');
    }
}
