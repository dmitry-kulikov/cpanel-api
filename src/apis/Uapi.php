<?php

namespace kdn\cpanel\api\apis;

use kdn\cpanel\api\Api;
use kdn\cpanel\api\modules\uapi\Brand;

/**
 * Class Uapi.
 * @package kdn\cpanel\api\apis
 *
 * @property Brand $brand
 */
class Uapi extends Api
{
    /**
     * @inheritdoc
     */
    public static function getDefaultDefinitions()
    {
        return [
            'brand' => Brand::className(),
        ];
    }
}
