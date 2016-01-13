<?php

namespace kdn\cpanel\api;

use kdn\cpanel\api\exceptions\InvalidConfigException;
use kdn\cpanel\api\exceptions\UnknownPropertyException;

/**
 * ServiceLocator implements a [service locator](http://en.wikipedia.org/wiki/Service_locator_pattern).
 * To use ServiceLocator, you first need to register service IDs with the corresponding service
 * definitions with the locator by calling [[set()]] or [[setDefinitions()]].
 * You can then call [[get()]] to retrieve a service with the specified ID. The locator will automatically
 * instantiate and configure the service according to the definition.
 *
 * For example,
 *
 * ```php
 * $locator = new \kdn\cpanel\api\ServiceLocator;
 * $locator->setDefinitions(
 *     [
 *         'api2' => [
 *             'class' => 'kdn\cpanel\api\Api2',
 *             'dnsLookup' => 'kdn\cpanel\api\modules\api2\DnsLookup',
 *         ],
 *         'uapi' => [
 *             'class' => 'kdn\cpanel\api\Uapi',
 *             'request' => 'kdn\cpanel\api\requests\UapiRequest',
 *         ],
 *     ]
 * );
 *
 * $api2 = $locator->get('api2');  // or $locator->api2
 * $uapi = $locator->get('uapi');  // or $locator->uapi
 * ```
 *
 * Cpanel and API classes are all service locators.
 */
class ServiceLocator extends Object
{
    /**
     * @var array service definitions indexed by their IDs
     */
    protected $definitions = [];

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        $definitions = static::getDefaultDefinitions();
        if (array_key_exists('definitions', $config)) {
            $definitions = ArrayHelper::merge($definitions, $config['definitions']);
            unset($config['definitions']);
        }
        parent::__construct($config);
        $this->setDefinitions($definitions);
    }

    /**
     * Default service definitions of this locator class.
     * @return array default service definitions.
     */
    public static function getDefaultDefinitions()
    {
        return [];
    }

    /**
     * Getter magic method.
     * This method is overridden to support accessing services like reading properties.
     * @param string $name service name
     * @return object service object.
     * @throws InvalidConfigException
     * @throws UnknownPropertyException
     */
    public function __get($name)
    {
        if ($this->has($name)) {
            return $this->get($name);
        } else {
            throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . "::$name.");
        }
    }

    /**
     * Returns a value indicating whether the locator has the specified service definition.
     * @param string $id service ID (e.g. `uapi`)
     * @return boolean whether the locator has the specified service definition.
     * @see set()
     */
    public function has($id)
    {
        return isset($this->definitions[$id]);
    }

    /**
     * Creates the service instance with the specified ID.
     * @param string $id service ID (e.g. `uapi`)
     * @return object the service of the specified ID.
     * @throws InvalidConfigException if `$id` refers to a nonexistent service ID
     * @see has()
     * @see set()
     */
    public function get($id)
    {
        if (isset($this->definitions[$id])) {
            $definition = $this->definitions[$id];
            if (is_string($definition)) {
                return new $definition;
            } elseif (is_callable($definition, true)) {
                return call_user_func($definition);
            } elseif (is_array($definition)) {
                $class = $definition['class'];
                unset($definition['class']);
                return new $class($definition);
            } elseif (is_object($definition)) {
                return $definition;
            } else {
                throw new InvalidConfigException('Unexpected object definition type: ' . gettype($definition) . '.');
            }
        } else {
            throw new InvalidConfigException("Unknown service ID: $id.");
        }
    }

    /**
     * Registers a service definition with this locator.
     *
     * For example,
     *
     * ```php
     * // a class name
     * $locator->set('uapi', 'kdn\cpanel\api\Uapi');
     *
     * // a configuration array
     * $locator->set(
     *     'api2',
     *     [
     *         'class' => 'kdn\cpanel\api\Api2',
     *         'request' => 'kdn\cpanel\api\requests\Api2Request',
     *         'dnsLookup' => 'kdn\cpanel\api\modules\api2\DnsLookup',
     *     ]
     * );
     *
     * // an anonymous function
     * $locator->set(
     *     'uapi',
     *     function ($params) {
     *         return new \kdn\cpanel\api\Uapi;
     *     }
     * );
     *
     * // an instance
     * $locator->set('uapi', new \kdn\cpanel\api\Uapi);
     * ```
     *
     * If a service definition with the same ID already exists, it will be overwritten.
     *
     * @param string $id service ID (e.g. `uapi`)
     * @param mixed $definition the service definition to be registered with this locator;
     * it can be one of the following:
     * - a class name;
     * - a configuration array: the array contains name-value pairs that will be used to
     *   initialize the property values of the newly created object when [[get()]] is called;
     *   the `class` element is required and stands for the the class of the object to be created;
     * - a PHP callable: either an anonymous function or an array representing a class method (e.g. `['Foo', 'bar']`);
     *   the callable will be called by [[get()]] to return an object associated with the specified service ID;
     * - an object: when [[get()]] is called, this object will be returned
     * @throws InvalidConfigException if the definition is an invalid configuration array
     */
    public function set($id, $definition)
    {
        if ($definition === null) {
            unset($this->definitions[$id]);
            return;
        }

        if (is_object($definition) || is_callable($definition, true)) {
            // an object, a class name, or a PHP callable
            $this->definitions[$id] = $definition;
        } elseif (is_array($definition)) {
            // a configuration array
            if (isset($definition['class'])) {
                $this->definitions[$id] = $definition;
            } else {
                throw new InvalidConfigException(
                    "The configuration for the \"$id\" service must contain a \"class\" element."
                );
            }
        } else {
            throw new InvalidConfigException(
                "Unexpected configuration type for the \"$id\" service: " . gettype($definition) . '.'
            );
        }
    }

    /**
     * Removes the service from the locator.
     * @param string $id the service ID
     */
    public function clear($id)
    {
        unset($this->definitions[$id]);
    }

    /**
     * Returns the list of the service definitions.
     * @return array the list of the service definitions (ID => definition).
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * Registers a set of service definitions in this locator.
     * This is the bulk version of [[set()]]. The parameter should be an array
     * whose keys are service IDs and values the corresponding service definitions.
     * For more details on how to specify service IDs and definitions, please refer to [[set()]].
     * If a service definition with the same ID already exists, it will be overwritten.
     *
     * The following is an example for registering two service definitions:
     *
     * ```php
     * [
     *     'api2' => [
     *         'class' => 'kdn\cpanel\api\Api2',
     *         'dnsLookup' => 'kdn\cpanel\api\modules\api2\DnsLookup',
     *     ],
     *     'uapi' => [
     *         'class' => 'kdn\cpanel\api\Uapi',
     *         'request' => 'kdn\cpanel\api\requests\UapiRequest',
     *     ],
     * ]
     * ```
     *
     * @param array $definitions service definitions or instances
     */
    public function setDefinitions($definitions)
    {
        foreach ($definitions as $id => $definition) {
            $this->set($id, $definition);
        }
    }
}
