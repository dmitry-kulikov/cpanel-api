<?php

namespace kdn\cpanel\api\mocks;

use kdn\cpanel\api\ServiceLocator;

/**
 * Class ServiceLocatorMock.
 * @package kdn\cpanel\api\mocks
 */
class ServiceLocatorMock extends ServiceLocator
{
    public static function getDefaultDefinitions()
    {
        return [
            'objectMock' => [
                'class' => ObjectMock::className(),
                'publicProperty' => ['a'],
            ],
        ];
    }
}
