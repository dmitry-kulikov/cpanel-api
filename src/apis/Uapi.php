<?php

namespace kdn\cpanel\api\apis;

use kdn\cpanel\api\Api;

/**
 * Class Uapi.
 * @package kdn\cpanel\api\apis
 * @link https://documentation.cpanel.net/display/SDK/Guide+to+UAPI
 *
 * @property \kdn\cpanel\api\modules\uapi\Backup $backup
 * @property \kdn\cpanel\api\modules\uapi\Bandwidth $bandwidth
 * @property \kdn\cpanel\api\modules\uapi\Batch $batch
 * @property \kdn\cpanel\api\modules\uapi\Brand $brand
 */
class Uapi extends Api
{
    /**
     * @inheritdoc
     */
    public static function getDefaultDefinitions()
    {
        return [
            'backup' => 'kdn\cpanel\api\modules\uapi\Backup',
            'bandwidth' => 'kdn\cpanel\api\modules\uapi\Bandwidth',
            'batch' => 'kdn\cpanel\api\modules\uapi\Batch',
            'brand' => 'kdn\cpanel\api\modules\uapi\Brand',
        ];
    }
}
