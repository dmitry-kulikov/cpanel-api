<?php

namespace kdn\cpanel\api\modules\api2;

use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\modules\ModuleTestCase;

/**
 * Class Api2ModuleTestCase.
 * @package kdn\cpanel\api\modules\api2
 * @property \kdn\cpanel\api\modules\Api2Module $module
 */
abstract class Api2ModuleTestCase extends ModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $apiName = Cpanel::API_2;

    /**
     * @inheritdoc
     */
    protected function getMockResponseBody()
    {
        return <<<'EOT'
{
    "cpanelresult": {
        "apiversion": 2,
        "func": "function",
        "data": null,
        "event": {
          "result": 1
        },
        "module": "Module"
    }
}
EOT;
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->module->setTargetUsername(static::getCpanelAuthUsername());
    }
}
