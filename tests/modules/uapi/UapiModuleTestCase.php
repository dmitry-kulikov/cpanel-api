<?php

namespace kdn\cpanel\api\modules\uapi;

use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\modules\ModuleTestCase;

/**
 * Class UapiModuleTestCase.
 * @package kdn\cpanel\api\modules\uapi
 */
class UapiModuleTestCase extends ModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $apiName = Cpanel::UAPI;
}
