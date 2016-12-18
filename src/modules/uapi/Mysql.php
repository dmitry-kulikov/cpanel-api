<?php

namespace kdn\cpanel\api\modules\uapi;

/**
 * Class Mysql.
 * @package kdn\cpanel\api\modules\uapi
 * @method createDatabase($name)
 * https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Mysql%3A%3Acreate_database
 * @method deleteDatabase($name)
 * https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Mysql%3A%3Adelete_database
 */
class Mysql extends DatabaseModule
{
    /**
     * @inheritdoc
     */
    protected $name = 'Mysql';
}
