<?php

namespace kdn\cpanel\api;

use ReflectionObject;
use ReflectionProperty;

/**
 * Class Object.
 * @package kdn\cpanel\api
 */
class Object
{
    /**
     * Returns the fully qualified name of this class.
     * @return string the fully qualified name of this class.
     */
    public static function className()
    {
        return get_called_class();
    }

    /**
     * Constructor.
     * Initializes the object with the given configuration `$config`.
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($config = [])
    {
        if (!empty($config)) {
            $this->configure($config);
        }
    }

    /**
     * Configures an object with the property values.
     * @param array $properties the property values given in terms of name-value pairs
     */
    protected function configure($properties)
    {
        foreach ($properties as $name => $value) {
            $this->$name = $value;
        }
    }

    /**
     * Checks if property is defined for object and satisfies optional filter.
     * @param object $object an object instance
     * @param string $name name of the property being checked for
     * @param integer $filter the optional filter, for filtering desired property types;
     * it's configured using the ReflectionProperty constants; use null to disable filtering
     * @return boolean true if object has the property, otherwise false.
     */
    public static function hasProperty($object, $name, $filter = ReflectionProperty::IS_PUBLIC)
    {
        $reflection = new ReflectionObject($object);
        if (isset($filter)) {
            $properties = $reflection->getProperties($filter);
        } else {
            $properties = $reflection->getProperties();
        }
        foreach ($properties as $property) {
            if ($property->getName() === $name) {
                return true;
            }
        }
        return false;
    }
}
