<?php

namespace kdn\cpanel\api\modules\uapi;

use kdn\cpanel\api\modules\UapiModule;

/**
 * Class Brand.
 * @package kdn\cpanel\api\modules\uapi
 */
class Brand extends UapiModule
{
    /**
     * @inheritdoc
     */
    protected $name = 'Brand';

    /**
     * @link https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Brand%3A%3Aread
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function read()
    {
        return $this->get('read');
    }
}
