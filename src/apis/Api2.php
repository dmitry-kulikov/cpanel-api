<?php

namespace kdn\cpanel\api\apis;

use kdn\cpanel\api\Api;
use kdn\cpanel\api\modules\api2\DnsLookup;

/**
 * Class Api2.
 * @package kdn\cpanel\api\apis
 * @link https://documentation.cpanel.net/display/SDK/Guide+to+cPanel+API+2
 *
 * @property DnsLookup $dnsLookup
 */
class Api2 extends Api
{
    /**
     * @inheritdoc
     */
    public static function getDefaultDefinitions()
    {
        return [
            'dnsLookup' => DnsLookup::className(),
        ];
    }
}
