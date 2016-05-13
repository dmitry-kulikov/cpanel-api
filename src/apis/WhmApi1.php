<?php

namespace kdn\cpanel\api\apis;

use kdn\cpanel\api\Api;

/**
 * Class WhmApi1.
 * @package kdn\cpanel\api\apis
 * @link https://documentation.cpanel.net/display/SDK/Guide+to+WHM+API+1
 *
 * @property \kdn\cpanel\api\modules\whmApi1\ServerInformation $serverInformation
 */
class WhmApi1 extends Api
{
    /**
     * @inheritdoc
     */
    public static function getDefaultDefinitions()
    {
        return [
            'serverInformation' => 'kdn\cpanel\api\modules\whmApi1\ServerInformation',
        ];
    }
}
