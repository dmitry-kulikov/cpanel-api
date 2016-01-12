<?php

namespace kdn\cpanel\api;

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
}
