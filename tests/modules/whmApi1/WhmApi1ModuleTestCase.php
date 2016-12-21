<?php

namespace kdn\cpanel\api\modules\whmApi1;

use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\modules\ModuleTestCase;

/**
 * Class WhmApi1ModuleTestCase.
 * @package kdn\cpanel\api\modules\whmApi1
 */
abstract class WhmApi1ModuleTestCase extends ModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $apiName = Cpanel::WHM_API_1;

    /**
     * @inheritdoc
     */
    protected function getMockResponseBody()
    {
        return <<<'EOT'
{
    "data": null,
    "metadata": {
        "version": 1,
        "reason": "OK",
        "result": 1,
        "command": "command"
    }
}
EOT;
    }
}
