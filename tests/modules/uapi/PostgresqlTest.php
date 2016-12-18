<?php

namespace kdn\cpanel\api\modules\uapi;

/**
 * Class PostgresqlTest.
 * @package kdn\cpanel\api\modules\uapi
 * @property \kdn\cpanel\api\modules\uapi\Postgresql $module
 * @covers \kdn\cpanel\api\modules\UapiModule
 * @uses   \kdn\cpanel\api\Object
 * @uses   \kdn\cpanel\api\ServiceLocator
 * @uses   \kdn\cpanel\api\Cpanel
 * @uses   \kdn\cpanel\api\Auth
 * @uses   \kdn\cpanel\api\Api
 * @uses   \kdn\cpanel\api\apis\Uapi
 * @uses   \kdn\cpanel\api\Module
 * @uses   \kdn\cpanel\api\Response
 * @uses   \kdn\cpanel\api\responses\UapiResponse
 */
class PostgresqlTest extends DatabaseModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $moduleName = 'postgresql';

    /**
     * @inheritdoc
     */
    protected $apiModuleName = 'Postgresql';
}
