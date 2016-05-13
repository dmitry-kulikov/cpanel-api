<?php

namespace kdn\cpanel\api\responses;

use GuzzleHttp\Psr7\Response;
use kdn\cpanel\api\TestCase;

/**
 * Class WhmApi1ResponseTest.
 * @package kdn\cpanel\api\responses
 * @covers kdn\cpanel\api\Response
 * @uses   kdn\cpanel\api\Object
 */
class WhmApi1ResponseTest extends TestCase
{
    /**
     * @var WhmApi1Response
     */
    protected $response;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $response = <<<'EOT'
{
    "data": {
        "versions": [
            "ea-php54",
            "ea-php55",
            "ea-php56"
        ]
    },
    "metadata": {
        "version": 1,
        "reason": "Ok",
        "result": 1,
        "command": "php_get_installed_versions"
    }
}
EOT;
        $this->response = new WhmApi1Response(new Response(200, [], $response));
    }

    /**
     * @covers kdn\cpanel\api\responses\WhmApi1Response::denormalize
     * @small
     */
    public function testDenormalize()
    {
        $this->response->parse();
        $this->assertEquals(['versions' => ['ea-php54', 'ea-php55', 'ea-php56']], $this->response->data);
        $this->assertSame(1, $this->response->version);
        $this->assertEquals('Ok', $this->response->reason);
        $this->assertSame(1, $this->response->result);
        $this->assertEquals('php_get_installed_versions', $this->response->command);
    }
}
