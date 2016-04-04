<?php

namespace kdn\cpanel\api\modules;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use kdn\cpanel\api\Auth;
use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\TestCase;

/**
 * Class ModuleTestCase.
 * @package kdn\cpanel\api
 */
class ModuleTestCase extends TestCase
{
    /**
     * @var \kdn\cpanel\api\Module module under test
     */
    protected $module;

    /**
     * @var array container to hold the history
     */
    protected $historyContainer;

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
    protected static function getCpanelConfig()
    {
        return [
            'host' => static::getCpanelHost(),
            'auth' => new Auth(
                ['username' => static::getCpanelAuthUsername(), 'password' => static::getCpanelAuthPassword()]
            )
        ];
    }

    /**
     * Get last request from container which holds the history.
     * @return \GuzzleHttp\Psr7\Request last request.
     */
    protected function getLastRequest()
    {
        return end($this->historyContainer)['request'];
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->historyContainer = [];
        $handler = null;
        if (!static::getIntegrationTesting()) {
            $handler = new MockHandler([new Response(200)]);
        }
        $stack = HandlerStack::create($handler);
        $stack->push(Middleware::history($this->historyContainer));
        $this->module = (new Cpanel(static::getCpanelConfig()))->{$this->apiName}->{$this->moduleName}
            ->setClient(new Client(['handler' => $stack, 'verify' => static::getGuzzleRequestVerify()]));
    }
}
