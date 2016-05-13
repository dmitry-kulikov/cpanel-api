<?php

namespace kdn\cpanel\api;

/**
 * Class Cpanel.
 * @package kdn\cpanel\api
 *
 * @property \kdn\cpanel\api\apis\Api2 $api2
 * @property \kdn\cpanel\api\apis\Uapi $uapi
 * @property \kdn\cpanel\api\apis\WhmApi0 $whmApi0
 * @property \kdn\cpanel\api\apis\WhmApi1 $whmApi1
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
            static::API_2 => 'kdn\cpanel\api\apis\Api2',
            static::UAPI => 'kdn\cpanel\api\apis\Uapi',
            static::WHM_API_0 => 'kdn\cpanel\api\apis\WhmApi0',
            static::WHM_API_1 => 'kdn\cpanel\api\apis\WhmApi1',
        ];
    }

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        $object = parent::get($id);
        if (static::hasProperty($object, 'cpanel')) {
            $object->cpanel = $this;
        }
        return $object;
    }
}
