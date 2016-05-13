<?php

namespace kdn\cpanel\api\responses;

use kdn\cpanel\api\Response;

/**
 * Class WhmApi1Response.
 * @package kdn\cpanel\api\responses
 */
class WhmApi1Response extends Response
{
    /**
     * @var integer WHM API version
     */
    public $version;

    /**
     * @var string message of success, or reason for failure
     */
    public $reason;

    /**
     * @var integer whether the function succeeded
     */
    public $result;

    /**
     * @var string WHM API 1 function name
     */
    public $command;

    /**
     * @var array function's return data
     */
    public $data;

    /**
     * @inheritdoc
     */
    protected function denormalize($data)
    {
        $this->data = $data['data'];
        $params = ['version', 'reason', 'result', 'command'];
        foreach ($params as $param) {
            $this->$param = $data['metadata'][$param];
        }
    }
}
