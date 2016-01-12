<?php

namespace kdn\cpanel\api;

use kdn\cpanel\api\mocks\ObjectMock;

/**
 * Class ObjectTest.
 * @package kdn\cpanel\api
 */
class ObjectTest extends TestCase
{
    /**
     * @covers kdn\cpanel\api\Object::__construct
     * @covers kdn\cpanel\api\Object::configure
     * @small
     */
    public function testConstruct()
    {
        $object = new ObjectMock(
            [
                'publicProperty' => 'publicValue',
                'protectedProperty' => 'protectedValue',
            ]
        );
        $this->assertEquals('publicValue', $object->{'publicProperty'});
        $this->assertEquals('protectedValue', $object->getProtectedProperty());
    }

    /**
     * @covers kdn\cpanel\api\Object::className
     * @uses   kdn\cpanel\api\Object::__construct
     * @small
     */
    public function testClassName()
    {
        $object = new ObjectMock();
        $this->assertEquals('kdn\cpanel\api\mocks\ObjectMock', $object::className());
    }
}
