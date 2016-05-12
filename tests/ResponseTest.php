<?php

namespace kdn\cpanel\api;

use GuzzleHttp\Psr7\Response;
use kdn\cpanel\api\mocks\ResponseMock;

/**
 * Class ResponseTest.
 * @package kdn\cpanel\api
 * @uses kdn\cpanel\api\Object
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
        $this->response = new ResponseMock(new Response(200, [], '{"domain": "example.com"}'));
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
        $expectedResult = ['domain' => 'example.com'];
        $this->response->parse();
        $this->assertTrue($this->response->isParsed());
        $this->assertEquals($expectedResult, $this->response->data);
        // test that repeat of parsing doesn't cause errors
        $this->response->parse();
        $this->assertEquals($expectedResult, $this->response->data);
    }
}
