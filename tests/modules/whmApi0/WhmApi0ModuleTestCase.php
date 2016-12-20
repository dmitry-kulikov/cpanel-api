<?php

namespace kdn\cpanel\api\modules\whmApi0;

use kdn\cpanel\api\Auth;
use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\modules\ModuleTestCase;

/**
 * Class WhmApi0ModuleTestCase.
 * @package kdn\cpanel\api\modules\whmApi0
 */
abstract class WhmApi0ModuleTestCase extends ModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $apiName = Cpanel::WHM_API_0;

    /**
     * @inheritdoc
     */
    protected function getCpanelConfig()
    {
        $config = parent::getCpanelConfig();
        $config['host'] = static::getWhmHost();
        $config['auth'] = new Auth(
            ['username' => static::getWhmAuthUsername(), 'password' => static::getWhmAuthPassword()]
        );
        return $config;
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->module->setPort(static::getWhmPort());
    }
}
