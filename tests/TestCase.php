<?php

namespace kdn\cpanel\api;

use PHPUnit_Framework_TestCase;
use UnexpectedValueException;

/**
 * Class TestCase.
 * @package kdn\cpanel\api
 */
abstract class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Get value of environment variable "INTEGRATION_TESTING".
     * @return boolean value of environment variable "INTEGRATION_TESTING".
     */
    protected static function getIntegrationTesting()
    {
        $value = static::getBooleanableEnvironmentVariable('INTEGRATION_TESTING');
        if (!is_bool($value)) {
            throw new UnexpectedValueException(
                '"INTEGRATION_TESTING" should have boolean value, but value is "' . $value . '".'
            );
        }
        return $value;
    }

    /**
     * Get value of environment variable "CPANEL_HOST".
     * @return string value of environment variable "CPANEL_HOST".
     */
    protected static function getCpanelHost()
    {
        return static::getStringEnvironmentVariable('CPANEL_HOST');
    }

    /**
     * Get value of environment variable "CPANEL_DOMAIN".
     * @return string value of environment variable "CPANEL_DOMAIN".
     */
    protected static function getCpanelDomain()
    {
        return static::getStringEnvironmentVariable('CPANEL_DOMAIN');
    }

    /**
     * Get value of environment variable "CPANEL_AUTH_HASH".
     * @return string value of environment variable "CPANEL_AUTH_HASH".
     */
    protected static function getCpanelAuthHash()
    {
        return static::getStringEnvironmentVariable('CPANEL_AUTH_HASH');
    }

    /**
     * Get value of environment variable "CPANEL_AUTH_USERNAME".
     * @return string value of environment variable "CPANEL_AUTH_USERNAME".
     */
    protected static function getCpanelAuthUsername()
    {
        return static::getStringEnvironmentVariable('CPANEL_AUTH_USERNAME');
    }

    /**
     * Get value of environment variable "CPANEL_AUTH_PASSWORD".
     * @return string value of environment variable "CPANEL_AUTH_PASSWORD".
     */
    protected static function getCpanelAuthPassword()
    {
        return static::getStringEnvironmentVariable('CPANEL_AUTH_PASSWORD');
    }

    /**
     * Get value of environment variable "GUZZLE_REQUEST_VERIFY".
     * @return boolean|string value of environment variable "GUZZLE_REQUEST_VERIFY".
     */
    protected static function getGuzzleRequestVerify()
    {
        return static::getBooleanableEnvironmentVariable('GUZZLE_REQUEST_VERIFY', true);
    }

    /**
     * Get value of environment variable which may have boolean value.
     * @param string $variableName environment variable name
     * @param mixed $default default value which will be used if the environment variable does not exist
     * @return mixed value of environment variable.
     */
    protected static function getBooleanableEnvironmentVariable($variableName, $default = false)
    {
        $variable = getenv($variableName);
        if ($variable === false) {
            return $default;
        }
        if ($variable === '1') {
            return true;
        }
        if (empty($variable)) {
            return false;
        }
        return $variable;
    }

    /**
     * Get value of environment variable which should have string value.
     * @param string $variableName environment variable name
     * @return string value of environment variable.
     */
    protected static function getStringEnvironmentVariable($variableName)
    {
        $variable = getenv($variableName);
        if ($variable === false) {
            static::fail('Environment variable "' . $variableName . '" is not specified.');
        }
        return $variable;
    }

    /**
     * Get path to "data" directory.
     * @return string path to "data" directory.
     */
    protected function getDataPath()
    {
        return __DIR__ . '/data/';
    }
}
