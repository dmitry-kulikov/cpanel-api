<?php

namespace kdn\cpanel\api;

use kdn\cpanel\api\mocks\ObjectMock;
use kdn\cpanel\api\mocks\ServiceLocatorMock;

/**
 * Class ServiceLocatorTest.
 * @package kdn\cpanel\api
 * @uses kdn\cpanel\api\Object
 * @uses kdn\cpanel\api\helpers\ArrayHelper
 */
class ServiceLocatorTest extends TestCase
{
    /**
     * @var ServiceLocator
     */
    protected $locator;

    protected static function getServiceLocatorConfig()
    {
        return [
            'definitions' => [
                'object' => [
                    'class' => ObjectMock::className(),
                    'publicProperty' => 'publicValue',
                    'protectedProperty' => 'protectedValue',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->locator = new ServiceLocator(static::getServiceLocatorConfig());
    }

    /**
     * @covers kdn\cpanel\api\ServiceLocator::getDefaultDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::__construct
     * @uses   kdn\cpanel\api\ServiceLocator::set
     * @uses   kdn\cpanel\api\ServiceLocator::setDefinitions
     * @small
     */
    public function testGetDefaultDefinitions()
    {
        $this->assertEquals([], $this->locator->getDefaultDefinitions());
    }

    /**
     * @covers kdn\cpanel\api\ServiceLocator::__get
     * @uses   kdn\cpanel\api\ServiceLocator::__construct
     * @uses   kdn\cpanel\api\ServiceLocator::get
     * @uses   kdn\cpanel\api\ServiceLocator::getDefaultDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::has
     * @uses   kdn\cpanel\api\ServiceLocator::set
     * @uses   kdn\cpanel\api\ServiceLocator::setDefinitions
     * @small
     */
    public function testMagicGet()
    {
        $object = new ObjectMock(
            [
                'publicProperty' => 'publicValue',
                'protectedProperty' => 'protectedValue',
            ]
        );
        $this->assertEquals($object, $this->locator->{'object'});
    }

    /**
     * @covers kdn\cpanel\api\ServiceLocator::__get
     * @uses   kdn\cpanel\api\ServiceLocator::__construct
     * @uses   kdn\cpanel\api\ServiceLocator::getDefaultDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::has
     * @uses   kdn\cpanel\api\ServiceLocator::set
     * @uses   kdn\cpanel\api\ServiceLocator::setDefinitions
     * @expectedException \kdn\cpanel\api\exceptions\UnknownPropertyException
     * @expectedExceptionMessage Getting unknown property: kdn\cpanel\api\ServiceLocator::unknown.
     * @small
     */
    public function testMagicGetException()
    {
        $object = new ObjectMock(
            [
                'publicProperty' => 'publicValue',
                'protectedProperty' => 'protectedValue',
            ]
        );
        $this->assertEquals($object, $this->locator->{'unknown'});
    }

    /**
     * @covers kdn\cpanel\api\ServiceLocator::has
     * @uses   kdn\cpanel\api\ServiceLocator::__construct
     * @uses   kdn\cpanel\api\ServiceLocator::getDefaultDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::set
     * @uses   kdn\cpanel\api\ServiceLocator::setDefinitions
     * @small
     */
    public function testHas()
    {
        $this->assertTrue($this->locator->has('object'));
        $this->assertFalse($this->locator->has('unknown'));
    }

    /**
     * @covers kdn\cpanel\api\ServiceLocator::getDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::__construct
     * @uses   kdn\cpanel\api\ServiceLocator::getDefaultDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::set
     * @uses   kdn\cpanel\api\ServiceLocator::setDefinitions
     * @small
     */
    public function testGetDefinitions()
    {
        $this->assertEquals(static::getServiceLocatorConfig()['definitions'], $this->locator->getDefinitions());
    }

    /**
     * @covers kdn\cpanel\api\ServiceLocator::clear
     * @uses   kdn\cpanel\api\ServiceLocator::__construct
     * @uses   kdn\cpanel\api\ServiceLocator::getDefaultDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::has
     * @uses   kdn\cpanel\api\ServiceLocator::set
     * @uses   kdn\cpanel\api\ServiceLocator::setDefinitions
     * @small
     */
    public function testClear()
    {
        $this->locator->clear('object');
        $this->assertFalse($this->locator->has('object'));
    }

    public function setAndGetProvider()
    {
        return [
            'class name' => [ObjectMock::className(), new ObjectMock()],
            'configuration array' => [
                'object' => [
                    'class' => ObjectMock::className(),
                    'publicProperty' => 'publicValue',
                    'protectedProperty' => 'protectedValue',
                ],
                new ObjectMock(
                    [
                        'publicProperty' => 'publicValue',
                        'protectedProperty' => 'protectedValue',
                    ]
                ),
            ],
            'anonymous function' => [
                function () {
                    return new ObjectMock(['name' => 'value']);
                },
                new ObjectMock(['name' => 'value']),
            ],
            'array representing a class method' => [
                ['kdn\cpanel\api\ServiceLocatorTest', 'createObjectMock'],
                new ObjectMock(['name' => 'value']),
            ],
            'object' => [new ObjectMock(['name' => 'value']), new ObjectMock(['name' => 'value'])],
        ];
    }

    public static function createObjectMock()
    {
        return new ObjectMock(['name' => 'value']);
    }

    /**
     * @param mixed $definition
     * @param object $expectedResult
     * @covers       kdn\cpanel\api\ServiceLocator::get
     * @covers       kdn\cpanel\api\ServiceLocator::set
     * @uses         kdn\cpanel\api\ServiceLocator::__construct
     * @uses         kdn\cpanel\api\ServiceLocator::getDefaultDefinitions
     * @uses         kdn\cpanel\api\ServiceLocator::setDefinitions
     * @dataProvider setAndGetProvider
     * @small
     */
    public function testSetAndGet($definition, $expectedResult)
    {
        $this->locator->set('object', $definition);
        $this->assertEquals($expectedResult, $this->locator->get('object'));
    }

    /**
     * @covers kdn\cpanel\api\ServiceLocator::set
     * @uses   kdn\cpanel\api\ServiceLocator::__construct
     * @uses   kdn\cpanel\api\ServiceLocator::getDefaultDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::has
     * @uses   kdn\cpanel\api\ServiceLocator::setDefinitions
     * @small
     */
    public function testSetNull()
    {
        $this->locator->set('object', null);
        $this->assertFalse($this->locator->has('object'));
    }

    /**
     * @covers kdn\cpanel\api\ServiceLocator::set
     * @uses   kdn\cpanel\api\ServiceLocator::__construct
     * @uses   kdn\cpanel\api\ServiceLocator::getDefaultDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::setDefinitions
     * @expectedException \kdn\cpanel\api\exceptions\InvalidConfigException
     * @expectedExceptionMessage The configuration for the "object" service must contain a "class" element.
     * @small
     */
    public function testSetClassRequiredException()
    {
        $this->locator->set('object', ['publicProperty' => 'publicValue']);
    }

    /**
     * @covers kdn\cpanel\api\ServiceLocator::set
     * @uses   kdn\cpanel\api\ServiceLocator::__construct
     * @uses   kdn\cpanel\api\ServiceLocator::getDefaultDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::setDefinitions
     * @expectedException \kdn\cpanel\api\exceptions\InvalidConfigException
     * @expectedExceptionMessage Unexpected configuration type for the "object" service: boolean.
     * @small
     */
    public function testSetUnexpectedTypeException()
    {
        $this->locator->set('object', true);
    }

    /**
     * @covers kdn\cpanel\api\ServiceLocator::get
     * @uses   kdn\cpanel\api\ServiceLocator::__construct
     * @uses   kdn\cpanel\api\ServiceLocator::getDefaultDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::set
     * @uses   kdn\cpanel\api\ServiceLocator::setDefinitions
     * @expectedException \kdn\cpanel\api\exceptions\InvalidConfigException
     * @expectedExceptionMessage Unknown service ID: unknown.
     * @small
     */
    public function testGetUnknownServiceException()
    {
        $this->locator->get('unknown');
    }

    /**
     * @covers kdn\cpanel\api\ServiceLocator::get
     * @uses   kdn\cpanel\api\ServiceLocator::__construct
     * @uses   kdn\cpanel\api\ServiceLocator::getDefaultDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::set
     * @uses   kdn\cpanel\api\ServiceLocator::setDefinitions
     * @expectedException \kdn\cpanel\api\exceptions\InvalidConfigException
     * @expectedExceptionMessage Unexpected object definition type: boolean.
     * @small
     */
    public function testGetUnexpectedTypeException()
    {
        $reflectionClass = new \ReflectionClass(ServiceLocator::className());
        $reflectionProperty = $reflectionClass->getProperty('definitions');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->locator, ['object' => true]);
        $this->locator->get('object');
    }

    /**
     * @covers kdn\cpanel\api\ServiceLocator::setDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::__construct
     * @uses   kdn\cpanel\api\ServiceLocator::getDefaultDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::getDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::set
     * @small
     */
    public function testSetDefinitions()
    {
        $definitions = [
            'object' => Object::className(),
            'objectMock' => ['class' => ObjectMock::className()],
        ];
        $this->locator->setDefinitions($definitions);
        $this->assertEquals($definitions, $this->locator->getDefinitions());
    }

    /**
     * @covers kdn\cpanel\api\ServiceLocator::__construct
     * @uses   kdn\cpanel\api\ServiceLocator::getDefaultDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::getDefinitions
     * @uses   kdn\cpanel\api\ServiceLocator::set
     * @uses   kdn\cpanel\api\ServiceLocator::setDefinitions
     * @small
     */
    public function testConstruct()
    {
        $locator = new ServiceLocatorMock(
            [
                'definitions' => [
                    'objectMock' => [
                        'publicProperty' => ['b', 'c'],
                        'protectedProperty' => 'protectedValue',
                    ],
                    'object' => Object::className(),
                ],
            ]
        );
        $this->assertEquals(
            [
                'objectMock' => [
                    'class' => ObjectMock::className(),
                    'publicProperty' => ['a', 'b', 'c'],
                    'protectedProperty' => 'protectedValue',
                ],
                'object' => Object::className(),
            ],
            $locator->getDefinitions()
        );
    }
}
