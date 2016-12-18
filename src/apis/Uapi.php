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
 * @property \kdn\cpanel\api\modules\uapi\Mysql $mysql
 * @property \kdn\cpanel\api\modules\uapi\Postgresql $postgresql
 * @property \kdn\cpanel\api\modules\uapi\Ssl $ssl
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
            'mysql' => 'kdn\cpanel\api\modules\uapi\Mysql',
            'postgresql' => 'kdn\cpanel\api\modules\uapi\Postgresql',
            'ssl' => 'kdn\cpanel\api\modules\uapi\Ssl',
        ];
    }
}
