<?php

namespace kdn\cpanel\api\responses;

use kdn\cpanel\api\Response;

/**
 * Class UapiResponse.
 * @package kdn\cpanel\api\responses
 */
class UapiResponse extends Response
{
    /**
     * @var array messages about the function's results
     */
    public $messages;

    /**
     * @var array error messages, if errors occurred
     */
    public $errors;

    /**
     * @var integer whether the function itself was successful;
     * note: a value of 1 only indicates that the system successfully ran the function;
     * it does not indicate that the function completed its action or that it did not encounter errors
     */
    public $status;

    /**
     * @var array an array of additional metadata; often, this array includes the transformed parameter
     */
    public $metadata;

    /**
     * @var mixed function's return data
     */
    public $data;

    /**
     * @inheritdoc
     */
    protected function denormalize($data)
    {
        $params = ['messages', 'errors', 'status', 'metadata', 'data'];
        foreach ($params as $param) {
            $this->$param = $data[$param];
        }
        $paramsToArray = ['messages', 'errors'];
        foreach ($paramsToArray as $param) {
            if (!isset($this->$param)) {
                $this->$param = [];
            } else {
                if (!is_array($this->$param)) {
                    $this->$param = [$this->$param];
                }
            }
        }
    }
}
