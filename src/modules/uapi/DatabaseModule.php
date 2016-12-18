<?php

namespace kdn\cpanel\api\modules\uapi;

use kdn\cpanel\api\modules\UapiModule;

/**
 * Class DatabaseModule.
 * @package kdn\cpanel\api\modules\uapi
 */
abstract class DatabaseModule extends UapiModule
{
    /**
     * @param string $name
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function createDatabase($name)
    {
        return $this->post('create_database', ['name' => $name]);
    }

    /**
     * @param string $name
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function deleteDatabase($name)
    {
        return $this->post('delete_database', ['name' => $name]);
    }
}
