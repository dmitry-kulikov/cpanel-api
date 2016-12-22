<?php

namespace kdn\cpanel\api\modules;

use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\Module;
use kdn\cpanel\api\responses\WhmApi0Response;

/**
 * Class WhmApi0Module.
 * @package kdn\cpanel\api\modules
 * @method WhmApi0Response get($function, $params = [], $body = null, $requestOptions = [])
 * @method WhmApi0Response post($function, $params = [], $body = null, $requestOptions = [])
 */
abstract class WhmApi0Module extends Module
{
    /**
     * @inheritdoc
     */
    protected $port = 2087;

    /**
     * @inheritdoc
     */
    protected $serviceName = Cpanel::WHM_API_0;

    /**
     * @inheritdoc
     */
    protected $responseClass = 'kdn\cpanel\api\responses\WhmApi0Response';

    /**
     * @inheritdoc
     */
    protected function buildUri($function, $params)
    {
        return $this->getBaseUri()->withPath("json-api/$function")->withQuery(static::buildQuery($params));
    }
}
