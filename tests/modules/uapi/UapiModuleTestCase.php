<?php

namespace kdn\cpanel\api\modules\uapi;

use kdn\cpanel\api\Auth;
use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\modules\ModuleTestCase;

/**
 * Class UapiModuleTestCase.
 * @package kdn\cpanel\api\modules\uapi
 */
abstract class UapiModuleTestCase extends ModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $apiName = Cpanel::UAPI;

    /**
     * @inheritdoc
     */
    protected function getMockResponseBody()
    {
        return <<<'EOT'
{
    "messages": null,
    "errors": null,
    "status": 1,
    "metadata": {},
    "data": null
}
EOT;
    }

    /**
     * @inheritdoc
     */
    protected function getCpanelConfig()
    {
        $config = parent::getCpanelConfig();
        $config['host'] = static::getCpanelHost();
        $config['auth'] = new Auth(
            ['username' => static::getCpanelAuthUsername(), 'password' => static::getCpanelAuthPassword()]
        );
        return $config;
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->module->setPort(static::getCpanelPort());
    }
}
