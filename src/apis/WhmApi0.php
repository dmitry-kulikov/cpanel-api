<?php

namespace kdn\cpanel\api\apis;

use kdn\cpanel\api\Api;
use kdn\cpanel\api\modules\whmApi0\ServerInformation;

/**
 * Class WhmApi0.
 * @package kdn\cpanel\api\apis
 *
 * @property ServerInformation $serverInformation
 */
class WhmApi0 extends Api
{
    /**
     * @inheritdoc
     */
    public static function getDefaultDefinitions()
    {
        return [
            'serverInformation' => ServerInformation::className(),
        ];
    }
}
