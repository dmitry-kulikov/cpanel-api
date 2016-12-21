<?php

namespace kdn\cpanel\api\modules;

use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\responses\WhmApi1Response;

/**
 * Class WhmApi1Module.
 * @package kdn\cpanel\api\modules
 * @method WhmApi1Response get($function, $params = [], $body = null, $requestOptions = [])
 * @method WhmApi1Response post($function, $params = [], $body = null, $requestOptions = [])
 */
class WhmApi1Module extends WhmApi0Module
{
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
        $params['api.version'] = 1;
        return parent::buildUri($function, $params);
    }
}
