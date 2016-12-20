<?php

namespace kdn\cpanel\api\modules;

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\HistoryContainer;
use kdn\cpanel\api\TestCase;

/**
 * Class ModuleTestCase.
 * @package kdn\cpanel\api
 */
abstract class ModuleTestCase extends TestCase
{
    use HistoryContainer;

    /**
     * @var \kdn\cpanel\api\Module module under test
     */
    protected $module;

    /**
     * @var string name of API which module belongs
     */
    protected $apiName;

    /**
     * @var string module name
     */
    protected $moduleName;

    /**
     * Get configuration for Cpanel.
     * @return array configuration for Cpanel.
     */
    protected function getCpanelConfig()
    {
        $handler = null;
        if (!static::getIntegrationTesting()) {
            $responseBody = <<<'EOT'
{
    "messages": null,
    "errors": null,
    "status": 1,
    "metadata": {},
    "data": null
}
EOT;
            $handler = new MockHandler([new Response(200, [], $responseBody)]);
        }
        $stack = HandlerStack::create($handler);
        $stack->push(Middleware::history($this->historyContainer));
        return ['clientConfig' => ['handler' => $stack, 'verify' => static::getGuzzleRequestVerify()]];
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->clearHistoryContainer();
        $this->module = (new Cpanel($this->getCpanelConfig()))->{$this->apiName}->{$this->moduleName};
    }
}
