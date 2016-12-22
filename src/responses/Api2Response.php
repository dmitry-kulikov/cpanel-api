<?php

namespace kdn\cpanel\api\responses;

use kdn\cpanel\api\Response;

/**
 * Class Api2Response.
 * @package kdn\cpanel\api\responses
 */
class Api2Response extends Response
{
    /**
     * @var null|integer cPanel API version called, can be null in case of error
     */
    public $apiVersion;

    /**
     * @var null|string function name, can be null in case of error
     */
    public $func;

    /**
     * @var array function's return data
     */
    public $data;

    /**
     * @var null|array an array of information about the function call itself, can be null in case of error;
     * all cPanel API 2 functions include the result parameter in this array
     */
    public $event;

    /**
     * @var null|string module name, can be null in case of error
     */
    public $module;

    /**
     * @var null|string type, null in case of success
     */
    public $type;

    /**
     * @var null|string error message, null in case of success
     */
    public $error;

    /**
     * @inheritdoc
     */
    protected function denormalize($data)
    {
        $mapping = [
            'apiVersion' => 'apiversion',
            'func' => 'func',
            'data' => 'data',
            'event' => 'event',
            'module' => 'module',
            'type' => 'type',
            'error' => 'error',
        ];
        foreach ($mapping as $property => $key) {
            if (array_key_exists($key, $data['cpanelresult'])) {
                $this->$property = $data['cpanelresult'][$key];
            }
        }
    }
}
