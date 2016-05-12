<?php

namespace kdn\cpanel\api\mocks;

use kdn\cpanel\api\Response;

/**
 * Class ResponseMock.
 * @package kdn\cpanel\api\mocks
 */
class ResponseMock extends Response
{
    /**
     * @var mixed function's return data
     */
    public $data;

    /**
     * @inheritdoc
     */
    protected function getParams()
    {
        return ['data'];
    }
}
