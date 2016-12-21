<?php

namespace kdn\cpanel\api\modules\whmApi1;

use kdn\cpanel\api\modules\WhmApi1Module;

/**
 * Class ServerAdministration.
 * @package kdn\cpanel\api\modules\whmApi1
 */
class ServerAdministration extends WhmApi1Module
{
    /**
     * @inheritdoc
     */
    protected $name = 'ServerAdministration';

    /**
     * @link https://documentation.cpanel.net/display/SDK/WHM+API+1+Functions+-+gethostname
     * @return \kdn\cpanel\api\responses\WhmApi1Response parsed response to request.
     */
    public function getHostName()
    {
        return $this->get('gethostname');
    }
}
