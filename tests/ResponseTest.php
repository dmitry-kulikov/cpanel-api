<?php

namespace kdn\cpanel\api;

use GuzzleHttp\Psr7\Response;
use kdn\cpanel\api\mocks\ResponseMock;

/**
 * Class ResponseTest.
 * @package kdn\cpanel\api
 * @uses kdn\cpanel\api\Object
 * @uses kdn\cpanel\api\JsonHelper
 */
class ResponseTest extends TestCase
{
    /**
     * @var ResponseMock
     */
    protected $response;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $response = ['data' => ['domain' => 'example.com']];
        $this->response = new ResponseMock(new Response(200, [], json_encode($response)));
    }

    /**
     * @covers kdn\cpanel\api\Response::isParsed
     * @uses   kdn\cpanel\api\Response::__construct
     * @small
     */
    public function testIsParsed()
    {
        $this->assertFalse($this->response->isParsed());
    }

    /**
     * @covers kdn\cpanel\api\Response::__construct
     * @covers kdn\cpanel\api\Response::parse
     * @uses   kdn\cpanel\api\Response::isParsed
     * @small
     */
    public function testParse()
    {
        $this->response->parse();
        $this->assertTrue($this->response->isParsed());
        $this->assertEquals(['domain' => 'example.com'], $this->response->data);
        // test that repeat of parsing doesn't cause errors
        $this->response->parse();
        $this->assertEquals(['domain' => 'example.com'], $this->response->data);
    }

    /**
     * @covers kdn\cpanel\api\Response::__construct
     * @covers kdn\cpanel\api\Response::parse
     * @uses   kdn\cpanel\api\Response::isParsed
     * @expectedException \kdn\cpanel\api\exceptions\InvalidJsonException
     * @expectedExceptionMessage Invalid JSON: syntax error.
     * @small
     */
    public function testParseInvalidJsonException()
    {
        $this->response = new ResponseMock(new Response(200, [], '{'));
        $this->response->parse();
    }
}
