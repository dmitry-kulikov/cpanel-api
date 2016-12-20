<?php

namespace kdn\cpanel\api\apis;

use kdn\cpanel\api\Api;

/**
 * Class WhmApi0.
 * @package kdn\cpanel\api\apis
 * @link https://documentation.cpanel.net/display/SDK/Guide+to+WHM+API+0
 *
 * @property \kdn\cpanel\api\modules\whmApi0\ServerAdministration $serverAdministration
 */
class WhmApi0 extends Api
{
    /**
     * @inheritdoc
     */
    public static function getDefaultDefinitions()
    {
        return [
            'serverAdministration' => 'kdn\cpanel\api\modules\whmApi0\ServerAdministration',
        ];
    }
}
