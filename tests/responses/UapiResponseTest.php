<?php

namespace kdn\cpanel\api\responses;

use GuzzleHttp\Psr7\Response;
use kdn\cpanel\api\TestCase;

/**
 * Class UapiResponseTest.
 * @package kdn\cpanel\api\responses
 * @covers kdn\cpanel\api\Response
 * @uses   kdn\cpanel\api\Object
 */
class UapiResponseTest extends TestCase
{
    /**
     * @var UapiResponse
     */
    protected $response;

    /**
     * @covers kdn\cpanel\api\responses\UapiResponse::denormalize
     * @small
     */
    public function testDenormalize()
    {
        $response = <<<'EOT'
{
    "data": null,
    "messages": null,
    "metadata": {},
    "status": 1,
    "errors": null
}
EOT;
        $this->response = new UapiResponse(new Response(200, [], $response));
        $this->response->parse();
        $this->assertEquals(null, $this->response->data);
        $this->assertEquals([], $this->response->messages);
        $this->assertEquals([], $this->response->metadata);
        $this->assertSame(1, $this->response->status);
        $this->assertEquals([], $this->response->errors);

        $response = <<<'EOT'
{
    "data": [
        null,
        null,
        "The domain resolves to Mars. Beep beep beep."
    ],
    "messages": "Message",
    "metadata": {
        "transformed": 1
    },
    "status": 1,
    "errors": "Error"
}
EOT;
        $this->response = new UapiResponse(new Response(200, [], $response));
        $this->response->parse();
        $this->assertEquals([null, null, 'The domain resolves to Mars. Beep beep beep.'], $this->response->data);
        $this->assertEquals(['Message'], $this->response->messages);
        $this->assertSame(['transformed' => 1], $this->response->metadata);
        $this->assertSame(1, $this->response->status);
        $this->assertEquals(['Error'], $this->response->errors);

        $response = <<<'EOT'
{
    "data": null,
    "messages": ["Message"],
    "metadata": {},
    "status": 0,
    "errors": ["Error"]
}
EOT;
        $this->response = new UapiResponse(new Response(200, [], $response));
        $this->response->parse();
        $this->assertEquals(null, $this->response->data);
        $this->assertEquals(['Message'], $this->response->messages);
        $this->assertEquals([], $this->response->metadata);
        $this->assertSame(0, $this->response->status);
        $this->assertEquals(['Error'], $this->response->errors);
    }
}
