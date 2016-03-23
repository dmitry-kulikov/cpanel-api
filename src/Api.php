<?php

namespace kdn\cpanel\api;

/**
 * Class Api.
 * @package kdn\cpanel\api
 */
abstract class Api extends ServiceLocator
{
    /**
     * @var Cpanel Cpanel object
     */
    public $cpanel;

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        $object = parent::get($id);
        if (static::hasProperty($object, 'cpanel')) {
            $object->cpanel = $this->cpanel;
        }
        return $object;
    }
}
