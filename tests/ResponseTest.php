<?php

namespace kdn\cpanel\api;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use kdn\cpanel\api\mocks\ResponseMock;

/**
 * Class ResponseTest.
 * @package kdn\cpanel\api
 * @uses \kdn\cpanel\api\Object
 */
class ResponseTest extends TestCase
{
    /**
     * @var ResponseMock
     */
    protected $response;

    /**
     * Get response body for response mock.
     * @return string response body.
     */
    protected static function getResponseBody()
    {
        return '{"domain": "example.com"}';
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->response = new ResponseMock(new GuzzleResponse(200, [], static::getResponseBody()));
    }

    /**
     * @covers \kdn\cpanel\api\Response::getRawResponse
     * @uses   \kdn\cpanel\api\Response::__construct
     * @small
     */
    public function testGetRawResponse()
    {
        $rawResponse = new GuzzleResponse();
        $this->assertSame($rawResponse, (new ResponseMock($rawResponse))->getRawResponse());
    }

    /**
     * @covers \kdn\cpanel\api\Response::isParsed
     * @uses   \kdn\cpanel\api\Response::__construct
     * @small
     */
    public function testIsParsed()
    {
        $this->assertFalse($this->response->isParsed());
    }

    /**
     * @covers \kdn\cpanel\api\Response::__construct
     * @covers \kdn\cpanel\api\Response::parse
     * @uses   \kdn\cpanel\api\Response::getRawResponse
     * @uses   \kdn\cpanel\api\Response::isParsed
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

    /**
     * @covers \kdn\cpanel\api\Response::__construct
     * @covers \kdn\cpanel\api\Response::parse
     * @uses   \kdn\cpanel\api\Response::getRawResponse
     * @uses   \kdn\cpanel\api\Response::isParsed
     * @small
     */
    public function testRawResponseReadingAfterParse()
    {
        $this->assertEquals(
            static::getResponseBody(),
            $this->response->parse()->getRawResponse()->getBody()->getContents()
        );
    }
}
