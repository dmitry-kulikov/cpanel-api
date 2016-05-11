<?php

namespace kdn\cpanel\api\mocks;

use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\Module;

/**
 * Class ModuleMock.
 * @package kdn\cpanel\api\mocks
 */
class ModuleMock extends Module
{
    /**
     * @inheritdoc
     */
    protected $port = 2083;

    /**
     * @inheritdoc
     */
    protected $name = 'Mock';

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
        return $this->getBaseUri()->withPath($function)->withQuery(static::buildQuery($params));
    }
}
