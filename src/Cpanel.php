<?php

namespace kdn\cpanel\api;

use kdn\cpanel\api\apis\Api2;
use kdn\cpanel\api\apis\Uapi;
use kdn\cpanel\api\apis\WhmApi0;
use kdn\cpanel\api\apis\WhmApi1;

/**
 * Class Cpanel.
 * @package kdn\cpanel\api
 *
 * @property Api2 $api2
 * @property Uapi $uapi
 * @property WhmApi0 $whmApi0
 * @property WhmApi1 $whmApi1
 */
class Cpanel extends ServiceLocator
{
    /**
     * Names of APIs.
     */
    const API_2 = 'api2';
    const UAPI = 'uapi';
    const WHM_API_0 = 'whmApi0';
    const WHM_API_1 = 'whmApi1';

    /**
     * @var string cPanel host
     */
    public $host;

    /**
     * @var string protocol which should be used to perform requests
     */
    public $protocol = 'https';

    /**
     * @var Auth authentication method object
     */
    public $auth;

    /**
     * @inheritdoc
     */
    public static function getDefaultDefinitions()
    {
        return [
            static::API_2 => Api2::className(),
            static::UAPI => Uapi::className(),
            static::WHM_API_0 => WhmApi0::className(),
            static::WHM_API_1 => WhmApi1::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        $object = parent::get($id);
        if ($object instanceof Api) {
            $object->cpanel = $this;
        }
        return $object;
    }
}
