<?php

namespace kdn\cpanel\api;

use kdn\cpanel\api\mocks\ObjectMock;
use ReflectionProperty;

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
        $object = new ObjectMock(['publicProperty' => 'publicValue', 'protectedProperty' => 'protectedValue']);
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

    public function hasPropertyProvider()
    {
        $object = new ObjectMock(['publicProperty' => 'publicValue', 'protectedProperty' => 'protectedValue']);
        $public = ReflectionProperty::IS_PUBLIC;
        $protected = ReflectionProperty::IS_PROTECTED;
        return [
            'public property without filter' => [$object, 'publicProperty', null, true],
            'protected property without filter' => [$object, 'protectedProperty', null, true],
            'public property with public filter' => [$object, 'publicProperty', $public, true],
            'protected property with protected filter' => [$object, 'protectedProperty', $protected, true],
            'public property with protected filter' => [$object, 'publicProperty', $protected, false],
            'protected property with public filter' => [$object, 'protectedProperty', $public, false],
        ];
    }

    /**
     * @param object $object
     * @param string $propertyName
     * @param null|integer $filter
     * @param boolean $expectedResult
     * @covers       kdn\cpanel\api\Object::hasProperty
     * @dataProvider hasPropertyProvider
     * @small
     */
    public function testHasProperty($object, $propertyName, $filter, $expectedResult)
    {
        $this->assertEquals($expectedResult, Object::hasProperty($object, $propertyName, $filter));
    }
}
