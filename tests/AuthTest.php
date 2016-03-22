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
                Auth::SINGLE_SIGN_ON => [
                    'required' => ['username', 'password', 'targetUsername'],
                    'services' => [Cpanel::API_2, Cpanel::UAPI, Cpanel::WHM_API_0, Cpanel::WHM_API_1],
                ],
                Auth::USERNAME_PASSWORD => [
                    'required' => ['username', 'password'],
                    'services' => [Cpanel::API_2, Cpanel::UAPI, Cpanel::WHM_API_0, Cpanel::WHM_API_1],
                ],
                Auth::HASH => [
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
            Auth::HASH => [['type' => Auth::HASH, 'hash' => 'HASH']],
            Auth::USERNAME_PASSWORD => [
                [
                    'type' => Auth::USERNAME_PASSWORD, 'username' => 'USERNAME', 'password' => 'PASSWORD'
                ]
            ],
            Auth::SINGLE_SIGN_ON => [
                [
                    'type' => Auth::SINGLE_SIGN_ON,
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
        new Auth(['type' => Auth::HASH, 'username' => 'USERNAME', 'password' => 'PASSWORD']);
    }

    public function getAuthTypeProvider()
    {
        $data = $this->validateAuthTypeProvider();
        foreach ($data as $name => $params) {
            $data[$name][] = $name; // data set name and authentication method type are same
        }
        return $data;
    }

    /**
     * @param array $config
     * @param string $expectedType
     * @covers       kdn\cpanel\api\Auth::__construct
     * @covers       kdn\cpanel\api\Auth::getAuthType
     * @uses         kdn\cpanel\api\Auth::getMethods
     * @uses         kdn\cpanel\api\Auth::validateAuthType
     * @dataProvider getAuthTypeProvider
     * @small
     */
    public function testGetAuthType($config, $expectedType)
    {
        $this->assertEquals($expectedType, (new Auth($config))->getAuthType());
    }

    public function determineAuthTypeProvider()
    {
        return [
            Auth::HASH => [['hash' => 'HASH'], Auth::HASH],
            Auth::USERNAME_PASSWORD => [['username' => 'USERNAME', 'password' => 'PASSWORD'], Auth::USERNAME_PASSWORD],
            Auth::SINGLE_SIGN_ON => [
                ['username' => 'USERNAME', 'password' => 'PASSWORD', 'targetUsername' => 'TARGET'],
                Auth::SINGLE_SIGN_ON,
            ],
        ];
    }

    /**
     * @param array $config
     * @param string $expectedType
     * @covers       kdn\cpanel\api\Auth::__construct
     * @covers       kdn\cpanel\api\Auth::determineAuthType
     * @uses         kdn\cpanel\api\Auth::getAuthType
     * @uses         kdn\cpanel\api\Auth::getMethods
     * @dataProvider determineAuthTypeProvider
     * @small
     */
    public function testDetermineAuthType($config, $expectedType)
    {
        $this->assertEquals($expectedType, (new Auth($config))->getAuthType());
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
