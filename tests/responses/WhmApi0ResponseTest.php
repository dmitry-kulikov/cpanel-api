<?php

namespace kdn\cpanel\api\responses;

use GuzzleHttp\Psr7\Response;
use kdn\cpanel\api\TestCase;

/**
 * Class WhmApi0ResponseTest.
 * @package kdn\cpanel\api\responses
 * @covers kdn\cpanel\api\Response
 * @uses   kdn\cpanel\api\Object
 */
class WhmApi0ResponseTest extends TestCase
{
    /**
     * @var WhmApi0Response
     */
    protected $response;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $response = <<<'EOT'
{
    "hostname": "hostname.example.com"
}
EOT;
        $this->response = new WhmApi0Response(new Response(200, [], $response));
    }

    /**
     * @covers kdn\cpanel\api\responses\WhmApi0Response::denormalize
     * @small
     */
    public function testDenormalize()
    {
        $this->response->parse();
        $this->assertEquals(['hostname' => 'hostname.example.com'], $this->response->data);
    }
}
