<?php

namespace kdn\cpanel\api\modules;

use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\Module;

/**
 * Class Api2Module.
 * @package kdn\cpanel\api\modules
 */
class Api2Module extends Module
{
    /**
     * @inheritdoc
     */
    protected $port = 2087;

    /**
     * @inheritdoc
     */
    protected $serviceName = Cpanel::API_2;

    /**
     * @inheritdoc
     */
    protected $responseClass = 'kdn\cpanel\api\responses\Api2Response';

    /**
     * @inheritdoc
     */
    protected function buildUri($function, $params)
    {
        return $this->getBaseUri();
    }
}
