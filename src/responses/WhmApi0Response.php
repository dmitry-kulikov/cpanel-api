<?php

namespace kdn\cpanel\api\responses;

use kdn\cpanel\api\Response;

/**
 * Class WhmApi0Response.
 * @package kdn\cpanel\api\responses
 */
class WhmApi0Response extends Response
{
    /**
     * @var array function's return data
     */
    public $data;

    /**
     * @inheritdoc
     */
    protected function denormalize($data)
    {
        $this->data = $data;
    }
}
