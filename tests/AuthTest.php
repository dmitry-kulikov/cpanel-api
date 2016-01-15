<?php

namespace kdn\cpanel\api;

/**
 * Class AuthTest.
 * @package kdn\cpanel\api
 * @uses kdn\cpanel\api\Object
 */
class AuthTest extends TestCase
{
    /**
     * @covers kdn\cpanel\api\Auth::getMethods
     * @small
     */
    public function testGetMethods()
    {
        $this->assertEquals(
            [
                'singleSignOn' => [
                    'required' => ['username', 'password', 'targetUsername'],
                    'services' => [Cpanel::API_2, Cpanel::UAPI, Cpanel::WHM_API_0, Cpanel::WHM_API_1],
                ],
                'usernamePassword' => [
                    'required' => ['username', 'password'],
                    'services' => [Cpanel::API_2, Cpanel::UAPI, Cpanel::WHM_API_0, Cpanel::WHM_API_1],
                ],
                'hash' => [
                    'required' => ['hash'],
                    'services' => [Cpanel::API_2, Cpanel::WHM_API_0, Cpanel::WHM_API_1],
                ],
            ],
            Auth::getMethods()
        );
    }

    /**
     * @covers kdn\cpanel\api\Auth::getMethodsInfo
     * @uses   kdn\cpanel\api\Auth::getMethods
     * @small
     */
    public function testGetMethodsInfo()
    {
        $this->assertEquals(
            'Allowed authentication methods:
 - singleSignOn: requires "username", "password", "targetUsername", allows to use api2, uapi, whmApi0, whmApi1
 - usernamePassword: requires "username", "password", allows to use api2, uapi, whmApi0, whmApi1
 - hash: requires "hash", allows to use api2, whmApi0, whmApi1',
            Auth::getMethodsInfo()
        );
    }

    public function validateAuthTypeProvider()
    {
        return [
            'hash' => [['type' => 'hash', 'hash' => 'HASH']],
            'usernamePassword' => [['type' => 'usernamePassword', 'username' => 'USERNAME', 'password' => 'PASSWORD']],
            'singleSignOn' => [
                [
                    'type' => 'singleSignOn',
                    'username' => 'USERNAME',
                    'password' => 'PASSWORD',
                    'targetUsername' => 'TARGET',
                ],
            ],
        ];
    }

    /**
     * @param array $config
     * @covers       kdn\cpanel\api\Auth::__construct
     * @covers       kdn\cpanel\api\Auth::validateAuthType
     * @uses         kdn\cpanel\api\Auth::getMethods
     * @dataProvider validateAuthTypeProvider
     * @small
     */
    public function testValidateAuthType($config)
    {
        $this->assertInstanceOf(Auth::className(), new Auth($config));
    }

    /**
     * @covers kdn\cpanel\api\Auth::__construct
     * @covers kdn\cpanel\api\Auth::validateAuthType
     * @uses   kdn\cpanel\api\Auth::getMethods
     * @uses   kdn\cpanel\api\Auth::getMethodsInfo
     * @expectedException \kdn\cpanel\api\exceptions\InvalidConfigException
     * @expectedExceptionMessage Unknown authentication method.
     * @small
     */
    public function testValidateAuthTypeUnknownAuthenticationMethodException()
    {
        new Auth(['type' => 'test']);
    }

    /**
     * @covers kdn\cpanel\api\Auth::__construct
     * @covers kdn\cpanel\api\Auth::validateAuthType
     * @uses   kdn\cpanel\api\Auth::getMethods
     * @expectedException \kdn\cpanel\api\exceptions\InvalidConfigException
     * @expectedExceptionMessage hash authentication method requires the following data: "hash".
     * @small
     */
    public function testValidateAuthTypeNotEnoughDataException()
    {
        new Auth(['type' => 'hash', 'username' => 'USERNAME', 'password' => 'PASSWORD']);
    }

    public function determineAuthTypeProvider()
    {
        return [
            'hash' => [['hash' => 'HASH'], 'hash'],
            'usernamePassword' => [['username' => 'USERNAME', 'password' => 'PASSWORD'], 'usernamePassword'],
            'singleSignOn' => [
                ['username' => 'USERNAME', 'password' => 'PASSWORD', 'targetUsername' => 'TARGET'],
                'singleSignOn',
            ],
        ];
    }

    /**
     * @param array $config
     * @param string $expectedType
     * @covers       kdn\cpanel\api\Auth::__construct
     * @covers       kdn\cpanel\api\Auth::determineAuthType
     * @uses         kdn\cpanel\api\Auth::getMethods
     * @dataProvider determineAuthTypeProvider
     * @small
     */
    public function testDetermineAuthType($config, $expectedType)
    {
        $this->assertEquals($expectedType, (new Auth($config))->type);
    }

    /**
     * @covers kdn\cpanel\api\Auth::__construct
     * @covers kdn\cpanel\api\Auth::determineAuthType
     * @uses   kdn\cpanel\api\Auth::getMethods
     * @uses   kdn\cpanel\api\Auth::getMethodsInfo
     * @expectedException \kdn\cpanel\api\exceptions\InvalidConfigException
     * @expectedExceptionMessage Can't determine authentication method.
     * @small
     */
    public function testDetermineAuthTypeCanNotDetermineAuthenticationMethodException()
    {
        new Auth;
    }
}
