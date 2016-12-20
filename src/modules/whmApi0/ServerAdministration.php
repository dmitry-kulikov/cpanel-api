<?php

namespace kdn\cpanel\api\modules\whmApi0;

use kdn\cpanel\api\modules\WhmApi0Module;

/**
 * Class ServerAdministration.
 * @package kdn\cpanel\api\modules\whmApi0
 */
class ServerAdministration extends WhmApi0Module
{
    /**
     * @inheritdoc
     */
    protected $name = 'ServerAdministration';

    /**
     * @link https://documentation.cpanel.net/display/SDK/WHM+API+0+Functions+-+gethostname
     * @return \kdn\cpanel\api\responses\WhmApi0Response parsed response to request.
     */
    public function getHostName()
    {
        return $this->get('gethostname');
    }
}
