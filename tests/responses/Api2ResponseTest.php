<?php

namespace kdn\cpanel\api\responses;

use GuzzleHttp\Psr7\Response;
use kdn\cpanel\api\TestCase;

/**
 * Class Api2ResponseTest.
 * @package kdn\cpanel\api\responses
 * @covers kdn\cpanel\api\Response
 * @uses   kdn\cpanel\api\Object
 */
class Api2ResponseTest extends TestCase
{
    /**
     * @var Api2Response
     */
    protected $response;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $response = <<<'EOT'
{
    "cpanelresult": {
        "apiversion": 2,
        "func": "userexists",
        "data": [
            {
                "userexists": "1"
            }
        ],
        "event": {
            "result": 1
        },
        "module": "Postgres"
    }
}
EOT;
        $this->response = new Api2Response(new Response(200, [], $response));
    }

    /**
     * @covers kdn\cpanel\api\responses\Api2Response::denormalize
     * @small
     */
    public function testDenormalize()
    {
        $this->response->parse();
        $this->assertSame(2, $this->response->apiVersion);
        $this->assertEquals('userexists', $this->response->func);
        $this->assertSame([['userexists' => '1']], $this->response->data);
        $this->assertSame(['result' => 1], $this->response->event);
        $this->assertEquals('Postgres', $this->response->module);
    }
}
