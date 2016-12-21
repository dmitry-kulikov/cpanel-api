<?php

namespace kdn\cpanel\api\modules\whmApi0;

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
    protected function getMockResponseBody()
    {
        return <<<'EOT'
{
    "result": [],
    "statusmsg": "Ok",
    "status": 1
}
EOT;
    }
}
