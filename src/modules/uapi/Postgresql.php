<?php

namespace kdn\cpanel\api\modules\uapi;

/**
 * Class Postgresql.
 * @package kdn\cpanel\api\modules\uapi
 * @method createDatabase($name)
 * https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Postgresql%3A%3Acreate_database
 * @method deleteDatabase($name)
 * https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Postgresql%3A%3Adelete_database
 */
class Postgresql extends DatabaseModule
{
    /**
     * @inheritdoc
     */
    protected $name = 'Postgresql';
}
