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
     * @param string $password
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function createUser($name, $password)
    {
        return $this->post('create_user', ['name' => $name, 'password' => $password]);
    }

    /**
     * @param string $name
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function deleteDatabase($name)
    {
        return $this->post('delete_database', ['name' => $name]);
    }

    /**
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function getRestrictions()
    {
        return $this->get('get_restrictions');
    }

    /**
     * @param string $oldName
     * @param string $newName
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function renameDatabase($oldName, $newName)
    {
        return $this->post('rename_database', ['oldname' => $oldName, 'newname' => $newName]);
    }

    /**
     * @param string $user
     * @param string $password
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    abstract public function setPassword($user, $password);
}
