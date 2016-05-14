<?php

namespace kdn\cpanel\api;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use kdn\cpanel\api\mocks\ModuleMock;
use kdn\cpanel\api\responses\UapiResponse;
use ReflectionObject;

/**
 * Class ModuleTest.
 * @package kdn\cpanel\api
 * @uses kdn\cpanel\api\Object
 * @uses kdn\cpanel\api\ServiceLocator
 * @uses kdn\cpanel\api\Cpanel
 * @uses kdn\cpanel\api\Auth
 * @uses kdn\cpanel\api\Response
 * @uses kdn\cpanel\api\responses\UapiResponse
 */
class ModuleTest extends TestCase
{
    use HistoryContainer;

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
     * Mocks client using mock handler with 1 response in queue and history middleware.
     */
    protected function mockClient()
    {
        $this->clearHistoryContainer();
        $stack = HandlerStack::create(new MockHandler([new Response(200)]));
        $stack->push(Middleware::history($this->historyContainer));
        $this->module->setClient(new Client(['handler' => $stack]));
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

    /**
     * @covers kdn\cpanel\api\Module::createRequest
     * @uses   kdn\cpanel\api\Module::getBaseUri
     * @uses   kdn\cpanel\api\Module::getHost
     * @uses   kdn\cpanel\api\Module::getProtocol
     * @uses   kdn\cpanel\api\Module::getPort
     * @small
     */
    public function testCreateRequest()
    {
        $this->assertInstanceOf(
            'GuzzleHttp\Psr7\Request',
            Module::createRequest('get', $this->module->getBaseUri())
        );
    }

    public function buildQueryProvider()
    {
        $params = ['version' => 1, 'Model' => ['a' => '1 2', 3]];
        return [
            'PHP_QUERY_RFC1738 encoding' => ['version=1&Model%5Ba%5D=1+2&Model%5B0%5D=3', $params, PHP_QUERY_RFC1738],
            'PHP_QUERY_RFC3986 encoding' => ['version=1&Model%5Ba%5D=1%202&Model%5B0%5D=3', $params, PHP_QUERY_RFC3986],
        ];
    }

    /**
     * @param string $expectedResult
     * @param array $params
     * @param integer $encoding
     * @covers       kdn\cpanel\api\Module::buildQuery
     * @dataProvider buildQueryProvider
     * @small
     */
    public function testBuildQuery($expectedResult, $params, $encoding)
    {
        $this->assertEquals($expectedResult, Module::buildQuery($params, $encoding));
    }

    /**
     * @covers kdn\cpanel\api\Module::buildQuery
     * @small
     */
    public function testBuildQueryDefaultEncoding()
    {
        $this->assertEquals(
            'version=1&Model%5Ba%5D=1%202&Model%5B0%5D=3',
            Module::buildQuery(['version' => 1, 'Model' => ['a' => '1 2', 3]])
        );
    }

    /**
     * @covers kdn\cpanel\api\Module::sendRequest
     * @uses   kdn\cpanel\api\Module::createRequest
     * @uses   kdn\cpanel\api\Module::getBaseUri
     * @uses   kdn\cpanel\api\Module::getClient
     * @uses   kdn\cpanel\api\Module::getHost
     * @uses   kdn\cpanel\api\Module::getPort
     * @uses   kdn\cpanel\api\Module::getProtocol
     * @uses   kdn\cpanel\api\Module::setClient
     * @small
     */
    public function testSendRequest()
    {
        $this->mockClient();
        $timeout = M_PI;
        $this->assertInstanceOf(
            'Psr\Http\Message\ResponseInterface',
            $this->module->sendRequest(
                Module::createRequest('get', $this->module->getBaseUri()),
                ['timeout' => $timeout]
            )
        );
        $request = $this->getLastRequest();
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('https://' . static::getCpanelHost() . ':2083', (string)$request->getUri());
        $this->assertEquals($timeout, $this->getLastRequestOptions()['timeout']);
    }

    /**
     * @covers kdn\cpanel\api\Module::send
     * @covers kdn\cpanel\api\Module::validateAuthType
     * @uses   kdn\cpanel\api\Module::buildHeaders
     * @uses   kdn\cpanel\api\Module::buildQuery
     * @uses   kdn\cpanel\api\Module::createRequest
     * @uses   kdn\cpanel\api\Module::getAuth
     * @uses   kdn\cpanel\api\Module::getBaseUri
     * @uses   kdn\cpanel\api\Module::getClient
     * @uses   kdn\cpanel\api\Module::getHost
     * @uses   kdn\cpanel\api\Module::getPort
     * @uses   kdn\cpanel\api\Module::getProtocol
     * @uses   kdn\cpanel\api\Module::getServiceName
     * @uses   kdn\cpanel\api\Module::sendRequest
     * @uses   kdn\cpanel\api\Module::setClient
     * @small
     */
    public function testSend()
    {
        $this->mockClient();
        $body = 'data=test';
        $timeout = M_PI;
        $response = $this->module->send(
            'put',
            'upload',
            ['version' => 1, 'Model' => ['a' => '1 2', 3]],
            $body,
            ['timeout' => $timeout]
        );
        $this->assertInstanceOf(UapiResponse::className(), $response);
        $this->assertTrue($response->isParsed());
        $request = $this->getLastRequest();
        $this->assertEquals('PUT', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':2083/upload?version=1&Model%5Ba%5D=1%202&Model%5B0%5D=3',
            (string)$request->getUri()
        );
        $this->assertEquals($body, $request->getBody()->getContents());
        $this->assertEquals($timeout, $this->getLastRequestOptions()['timeout']);
    }

    /**
     * @covers kdn\cpanel\api\Module::get
     * @uses   kdn\cpanel\api\Module::buildHeaders
     * @uses   kdn\cpanel\api\Module::buildQuery
     * @uses   kdn\cpanel\api\Module::createRequest
     * @uses   kdn\cpanel\api\Module::getAuth
     * @uses   kdn\cpanel\api\Module::getBaseUri
     * @uses   kdn\cpanel\api\Module::getClient
     * @uses   kdn\cpanel\api\Module::getHost
     * @uses   kdn\cpanel\api\Module::getPort
     * @uses   kdn\cpanel\api\Module::getProtocol
     * @uses   kdn\cpanel\api\Module::getServiceName
     * @uses   kdn\cpanel\api\Module::send
     * @uses   kdn\cpanel\api\Module::sendRequest
     * @uses   kdn\cpanel\api\Module::setClient
     * @uses   kdn\cpanel\api\Module::validateAuthType
     * @small
     */
    public function testGet()
    {
        $this->mockClient();
        $body = 'data=test';
        $timeout = M_PI;
        $response = $this->module->get(
            'read',
            ['version' => 1, 'Model' => ['a' => '1 2', 3]],
            $body,
            ['timeout' => $timeout]
        );
        $this->assertInstanceOf(UapiResponse::className(), $response);
        $this->assertTrue($response->isParsed());
        $request = $this->getLastRequest();
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':2083/read?version=1&Model%5Ba%5D=1%202&Model%5B0%5D=3',
            (string)$request->getUri()
        );
        $this->assertEquals($body, $request->getBody()->getContents());
        $this->assertEquals($timeout, $this->getLastRequestOptions()['timeout']);
    }

    /**
     * @covers kdn\cpanel\api\Module::post
     * @uses   kdn\cpanel\api\Module::buildHeaders
     * @uses   kdn\cpanel\api\Module::buildQuery
     * @uses   kdn\cpanel\api\Module::createRequest
     * @uses   kdn\cpanel\api\Module::getAuth
     * @uses   kdn\cpanel\api\Module::getBaseUri
     * @uses   kdn\cpanel\api\Module::getClient
     * @uses   kdn\cpanel\api\Module::getHost
     * @uses   kdn\cpanel\api\Module::getPort
     * @uses   kdn\cpanel\api\Module::getProtocol
     * @uses   kdn\cpanel\api\Module::getServiceName
     * @uses   kdn\cpanel\api\Module::send
     * @uses   kdn\cpanel\api\Module::sendRequest
     * @uses   kdn\cpanel\api\Module::setClient
     * @uses   kdn\cpanel\api\Module::validateAuthType
     * @small
     */
    public function testPost()
    {
        $this->mockClient();
        $body = 'data=test';
        $timeout = M_PI;
        $response = $this->module->post(
            'write',
            ['version' => 1, 'Model' => ['a' => '1 2', 3]],
            $body,
            ['timeout' => $timeout]
        );
        $this->assertInstanceOf(UapiResponse::className(), $response);
        $this->assertTrue($response->isParsed());
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':2083/write?version=1&Model%5Ba%5D=1%202&Model%5B0%5D=3',
            (string)$request->getUri()
        );
        $this->assertEquals($body, $request->getBody()->getContents());
        $this->assertEquals($timeout, $this->getLastRequestOptions()['timeout']);
    }

    public function validateAuthTypeInvalidAuthMethodExceptionProvider()
    {
        return [
            'null' => [null],
            'boolean' => [true],
            'integer' => [1],
            'float' => [1.2],
            'string' => ['test'],
            'array' => [[]],
        ];
    }

    /**
     * @param mixed $auth
     * @covers       kdn\cpanel\api\Module::validateAuthType
     * @uses         kdn\cpanel\api\Module::getAuth
     * @uses         kdn\cpanel\api\Module::send
     * @uses         kdn\cpanel\api\Module::setAuth
     * @dataProvider validateAuthTypeInvalidAuthMethodExceptionProvider
     * @expectedException \kdn\cpanel\api\exceptions\InvalidAuthMethodException
     * @expectedExceptionMessage The authentication method must be an object.
     * @small
     */
    public function testValidateAuthTypeInvalidAuthMethodException($auth)
    {
        $this->module->cpanel->auth = null;
        $this->module->setAuth($auth)->send('get', 'read');
    }

    /**
     * @covers kdn\cpanel\api\Module::validateAuthType
     * @uses   kdn\cpanel\api\Module::getAuth
     * @uses   kdn\cpanel\api\Module::getServiceName
     * @uses   kdn\cpanel\api\Module::send
     * @uses   kdn\cpanel\api\Module::setAuth
     * @expectedException \kdn\cpanel\api\exceptions\AuthMethodNotSupportedException
     * @expectedExceptionMessage Authentication method "hash" not supported by service "uapi".
     * @small
     */
    public function testValidateAuthTypeAuthMethodNotSupportedException()
    {
        $this->module->setAuth(new Auth(['hash' => static::getCpanelAuthHash()]))->send('get', 'read');
    }

    public function buildHeadersProvider()
    {
        return [
            Auth::USERNAME_PASSWORD => [
                'Basic dXNlcm5hbWU6cGFzc3dvcmQ=',
                new Auth(['username' => 'username', 'password' => 'password'])
            ],
            Auth::HASH => ['WHM root:hash', new Auth(['hash' => "h\na\rs\r\nh"])],
        ];
    }

    /**
     * @param string $expectedResult
     * @param Auth $auth
     * @covers       kdn\cpanel\api\Module::buildHeaders
     * @uses         kdn\cpanel\api\Module::buildQuery
     * @uses         kdn\cpanel\api\Module::getAuth
     * @uses         kdn\cpanel\api\Module::getBaseUri
     * @uses         kdn\cpanel\api\Module::getClient
     * @uses         kdn\cpanel\api\Module::getHost
     * @uses         kdn\cpanel\api\Module::getPort
     * @uses         kdn\cpanel\api\Module::getProtocol
     * @uses         kdn\cpanel\api\Module::getServiceName
     * @uses         kdn\cpanel\api\Module::createRequest
     * @uses         kdn\cpanel\api\Module::send
     * @uses         kdn\cpanel\api\Module::sendRequest
     * @uses         kdn\cpanel\api\Module::setAuth
     * @uses         kdn\cpanel\api\Module::setClient
     * @uses         kdn\cpanel\api\Module::validateAuthType
     * @dataProvider buildHeadersProvider
     * @small
     */
    public function testBuildHeaders($expectedResult, $auth)
    {
        $reflectionObject = new ReflectionObject($this->module);
        $property = $reflectionObject->getProperty('serviceName');
        $property->setAccessible(true);
        $property->setValue($this->module, Cpanel::API_2);

        $this->mockClient();
        $this->module->setAuth($auth)->send('get', 'read');
        $request = $this->getLastRequest();
        $this->assertEquals($expectedResult, $request->getHeaderLine('Authorization'));
    }
}
