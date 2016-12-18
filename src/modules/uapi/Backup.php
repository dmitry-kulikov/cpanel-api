<?php

namespace kdn\cpanel\api\modules\uapi;

use kdn\cpanel\api\modules\UapiModule;

/**
 * Class Backup.
 * @package kdn\cpanel\api\modules\uapi
 */
class Backup extends UapiModule
{
    /**
     * @inheritdoc
     */
    protected $name = 'Backup';

    /**
     * @link https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Backup%3A%3Alist_backups
     * @return \kdn\cpanel\api\Response parsed response to request.
     */
    public function listBackups()
    {
        return $this->get('list_backups');
    }
}
