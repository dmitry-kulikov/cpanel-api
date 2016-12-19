<?php

namespace kdn\cpanel\api\modules\uapi;

/**
 * Class Postgresql.
 * @package kdn\cpanel\api\modules\uapi
 * @method createDatabase($name)
 * https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Postgresql%3A%3Acreate_database
 * @method createUser($name, $password)
 * https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Postgresql%3A%3Acreate_user
 * @method deleteDatabase($name)
 * https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Postgresql%3A%3Adelete_database
 * @method getRestrictions()
 * https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Postgresql%3A%3Aget_restrictions
 * @method renameDatabase($oldName, $newName)
 * https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Postgresql%3A%3Arename_database
 */
class Postgresql extends DatabaseModule
{
    /**
     * @inheritdoc
     */
    protected $name = 'Postgresql';

    /**
     * @link https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Postgresql%3A%3Arename_user
     * @param string $oldName
     * @param string $newName
     * @param string $password
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function renameUser($oldName, $newName, $password)
    {
        return $this->post('rename_user', ['oldname' => $oldName, 'newname' => $newName, 'password' => $password]);
    }

    /**
     * @link https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Postgresql%3A%3Arename_user_no_password
     * @param string $oldName
     * @param string $newName
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function renameUserNoPassword($oldName, $newName)
    {
        return $this->post('rename_user_no_password', ['oldname' => $oldName, 'newname' => $newName]);
    }

    /**
     * @inheritdoc
     * @link https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Postgresql%3A%3Aset_password
     */
    public function setPassword($user, $password)
    {
        return $this->post('set_password', ['name' => $user, 'password' => $password]);
    }
}
