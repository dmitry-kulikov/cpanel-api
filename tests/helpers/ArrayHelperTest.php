<?php

namespace kdn\cpanel\api\helpers;

use kdn\cpanel\api\TestCase;

/**
 * Class ArrayHelperTest.
 * Based on code taken from Yii framework.
 * @package kdn\cpanel\api\helpers
 */
class ArrayHelperTest extends TestCase
{
    /**
     * @covers kdn\cpanel\api\helpers\ArrayHelper::merge
     * @small
     * @link http://www.yiiframework.com/
     * @copyright Copyright (c) 2008 Yii Software LLC
     * @license http://www.yiiframework.com/license/
     */
    public function testMerge()
    {
        $a = [
            'name' => 'Yii',
            'features' => [],
        ];
        $b = [
            'version' => '1.0',
            'options' => [
                'namespace' => false,
                'unitTest' => false,
            ],
            'features' => [
                'mvc',
            ],
        ];
        $c = [
            'version' => '1.1',
            'options' => [
                'unitTest' => true,
            ],
            'features' => [
                'gii',
            ],
        ];
        $d = [
            'version' => '2.0',
            'options' => [
                'namespace' => true,
            ],
            'features' => [
                'debug',
            ],
        ];
        $result = ArrayHelper::merge($a, $b, $c, $d);
        $expected = [
            'name' => 'Yii',
            'version' => '2.0',
            'options' => [
                'namespace' => true,
                'unitTest' => true,
            ],
            'features' => [
                'mvc',
                'gii',
                'debug',
            ],
        ];
        $this->assertEquals($expected, $result);
    }
}
