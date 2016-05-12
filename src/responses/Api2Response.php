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
     * @var integer cPanel API version called
     */
    public $apiVersion;

    /**
     * @var string function name
     */
    public $func;

    /**
     * @var array function's return data
     */
    public $data;

    /**
     * @var array an array of information about the function call itself;
     * all cPanel API 2 functions include the result parameter in this array
     */
    public $event;

    /**
     * @var string module name
     */
    public $module;

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
        ];
        foreach ($mapping as $property => $key) {
            $this->$property = $data['cpanelresult'][$key];
        }
    }
}
