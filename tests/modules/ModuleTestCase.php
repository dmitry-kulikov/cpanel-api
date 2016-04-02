<?php

namespace kdn\cpanel\api\modules;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
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
                ['username' => getenv('CPANEL_AUTH_USERNAME'), 'password' => getenv('CPANEL_AUTH_PASSWORD')]
            )
        ];
    }

    /**
     * Get environment variable "CPANEL_HOST".
     * @return boolean|string environment variable "CPANEL_HOST".
     */
    protected static function getCpanelHost()
    {
        return getenv('CPANEL_HOST');
    }

    /**
     * Get environment variable "GUZZLE_REQUEST_VERIFY".
     * @return boolean|string environment variable "GUZZLE_REQUEST_VERIFY".
     */
    protected static function getGuzzleRequestVerify()
    {
        $variable = getenv('GUZZLE_REQUEST_VERIFY');
        if ($variable === '1' || $variable === false) {
            return true;
        }
        if (empty($variable)) {
            return false;
        }
        return $variable;
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
        $stack = HandlerStack::create();
        $stack->push(Middleware::history($this->historyContainer));
        $this->module = (new Cpanel(static::getCpanelConfig()))->{$this->apiName}->{$this->moduleName}
            ->setClient(new Client(['handler' => $stack, 'verify' => static::getGuzzleRequestVerify()]));
        // todo use mocks
    }
}
