<?php

namespace kdn\cpanel\api\modules;

use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\Module;

/**
 * Class WhmApi1Module.
 * @package kdn\cpanel\api\modules
 */
class WhmApi1Module extends Module
{
    /**
     * @inheritdoc
     */
    protected $port = 2087;

    /**
     * @inheritdoc
     */
    protected $serviceName = Cpanel::WHM_API_1;

    /**
     * @inheritdoc
     */
    protected $responseClass = 'kdn\cpanel\api\responses\WhmApi1Response';

    /**
     * @inheritdoc
     */
    protected function buildUri($function, $params)
    {
        return $this->getBaseUri();
    }
}
