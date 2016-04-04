<?php

namespace kdn\cpanel\api;

use PHPUnit_Framework_TestCase;
use UnexpectedValueException;

/**
 * Class TestCase.
 * @package kdn\cpanel\api
 */
class TestCase extends PHPUnit_Framework_TestCase
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
     * @return boolean|string value of environment variable "CPANEL_HOST".
     */
    protected static function getCpanelHost()
    {
        return getenv('CPANEL_HOST');
    }

    /**
     * Get value of environment variable "CPANEL_AUTH_HASH".
     * @return boolean|string value of environment variable "CPANEL_AUTH_HASH".
     */
    protected static function getCpanelAuthHash()
    {
        return getenv('CPANEL_AUTH_HASH');
    }

    /**
     * Get value of environment variable "CPANEL_AUTH_USERNAME".
     * @return boolean|string value of environment variable "CPANEL_AUTH_USERNAME".
     */
    protected static function getCpanelAuthUsername()
    {
        return getenv('CPANEL_AUTH_USERNAME');
    }

    /**
     * Get value of environment variable "CPANEL_AUTH_PASSWORD".
     * @return boolean|string value of environment variable "CPANEL_AUTH_PASSWORD".
     */
    protected static function getCpanelAuthPassword()
    {
        return getenv('CPANEL_AUTH_PASSWORD');
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
}
