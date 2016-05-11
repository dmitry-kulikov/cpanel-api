<?php

namespace kdn\cpanel\api\modules;

use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\Module;

/**
 * Class UapiModule.
 * @package kdn\cpanel\api\modules
 */
class UapiModule extends Module
{
    /**
     * @inheritdoc
     */
    protected $port = 2083;

    /**
     * @inheritdoc
     */
    protected $serviceName = Cpanel::UAPI;

    /**
     * @inheritdoc
     */
    protected $responseClass = 'kdn\cpanel\api\responses\UapiResponse';

    /**
     * @inheritdoc
     */
    protected function buildUri($function, $params)
    {
        return $this->getBaseUri()->withPath("execute/{$this->getName()}/$function")
            ->withQuery(static::buildQuery($params));
    }
}
