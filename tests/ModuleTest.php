<?php

namespace kdn\cpanel\api;

use GuzzleHttp\Client;
use kdn\cpanel\api\mocks\ModuleMock;

/**
 * Class ModuleTest.
 * @package kdn\cpanel\api
 * @uses kdn\cpanel\api\Object
 * @uses kdn\cpanel\api\ServiceLocator
 * @uses kdn\cpanel\api\Cpanel
 * @uses kdn\cpanel\api\Auth
 */
class ModuleTest extends TestCase
{
    /**
     * @var ModuleMock
     */
    protected $module;

    /**
     * Get configuration for Cpanel.
     * @return array configuration for Cpanel.
     */
    protected static function getCpanelConfig()
    {
        return [
            'host' => static::getCpanelHost(),
            'auth' => new Auth(
                ['username' => static::getCpanelAuthUsername(), 'password' => static::getCpanelAuthPassword()]
            ),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->module = new ModuleMock(['cpanel' => new Cpanel(static::getCpanelConfig())]);
    }

    /**
     * @covers kdn\cpanel\api\Module::getName
     * @small
     */
    public function testGetName()
    {
        $this->assertEquals('Mock', $this->module->getName());
    }

    /**
     * @covers kdn\cpanel\api\Module::getServiceName
     * @small
     */
    public function testGetServiceName()
    {
        $this->assertEquals(Cpanel::UAPI, $this->module->getServiceName());
    }

    /**
     * @covers kdn\cpanel\api\Module::getHost
     * @small
     */
    public function testGetHost()
    {
        $cpanel = new Cpanel(static::getCpanelConfig());
        $this->module = new ModuleMock(['cpanel' => $cpanel]);
        $cpanel->host = 'test-get-host.example.com';
        $this->assertEquals($cpanel->host, $this->module->getHost());
    }

    /**
     * @covers kdn\cpanel\api\Module::getHost
     * @covers kdn\cpanel\api\Module::setHost
     * @small
     */
    public function testSetHostAndGetHost()
    {
        $host = 'test-get-host.example.com';
        $this->assertEquals($host, $this->module->setHost($host)->getHost());
    }

    /**
     * @covers kdn\cpanel\api\Module::getProtocol
     * @small
     */
    public function testGetProtocol()
    {
        $cpanel = new Cpanel(static::getCpanelConfig());
        $this->module = new ModuleMock(['cpanel' => $cpanel]);
        $cpanel->protocol = 'test-get-protocol';
        $this->assertEquals($cpanel->protocol, $this->module->getProtocol());
    }

    /**
     * @covers kdn\cpanel\api\Module::getProtocol
     * @covers kdn\cpanel\api\Module::setProtocol
     * @small
     */
    public function testSetProtocolAndGetProtocol()
    {
        $protocol = 'test-get-protocol';
        $this->assertEquals($protocol, $this->module->setProtocol($protocol)->getProtocol());
    }

    /**
     * @covers kdn\cpanel\api\Module::getPort
     * @covers kdn\cpanel\api\Module::setPort
     * @small
     */
    public function testSetPortAndGetPort()
    {
        $port = 65535;
        $this->assertEquals($port, $this->module->setPort($port)->getPort());
    }

    /**
     * @covers kdn\cpanel\api\Module::getAuth
     * @small
     */
    public function testGetAuth()
    {
        $cpanel = new Cpanel(static::getCpanelConfig());
        $this->module = new ModuleMock(['cpanel' => $cpanel]);
        $cpanel->auth = new Auth(['hash' => static::getCpanelAuthHash()]);
        $this->assertSame($cpanel->auth, $this->module->getAuth());
    }

    /**
     * @covers kdn\cpanel\api\Module::getAuth
     * @covers kdn\cpanel\api\Module::setAuth
     * @small
     */
    public function testSetAuthAndGetAuth()
    {
        $auth = new Auth(['hash' => static::getCpanelAuthHash()]);
        $this->assertSame($auth, $this->module->setAuth($auth)->getAuth());
    }

    /**
     * @covers kdn\cpanel\api\Module::getClient
     * @small
     */
    public function testGetClient()
    {
        $this->assertInstanceOf('GuzzleHttp\Client', $this->module->getClient());
    }

    /**
     * @covers kdn\cpanel\api\Module::getClient
     * @covers kdn\cpanel\api\Module::setClient
     * @small
     */
    public function testSetClientAndGetClient()
    {
        $client = new Client;
        $this->assertSame($client, $this->module->setClient($client)->getClient());
    }

    /**
     * @covers kdn\cpanel\api\Module::getBaseUri
     * @uses   kdn\cpanel\api\Module::getHost
     * @uses   kdn\cpanel\api\Module::getPort
     * @uses   kdn\cpanel\api\Module::getProtocol
     * @small
     */
    public function testGetBaseUri()
    {
        $uri = $this->module->getBaseUri();
        $this->assertInstanceOf('GuzzleHttp\Psr7\Uri', $uri);
        $this->assertEquals('https://' . static::getCpanelHost() . ':2083', (string)$uri);
    }
}
