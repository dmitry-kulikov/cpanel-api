<?php

namespace kdn\cpanel\api;

use kdn\cpanel\api\exceptions\InvalidConfigException;

/**
 * Class Auth.
 * @package kdn\cpanel\api
 */
class Auth extends Object
{
    /**
     * Names of authentication methods.
     */
    const SINGLE_SIGN_ON = 'singleSignOn';
    const USERNAME_PASSWORD = 'usernamePassword';
    const HASH = 'hash';

    /**
     * @var string hash used by Hash authentication method
     */
    public $hash;

    /**
     * @var string username
     */
    public $username;

    /**
     * @var string password
     */
    public $password;

    /**
     * @var string name of user for which session should be created in Single Sign On authentication method
     */
    public $targetUsername;

    /**
     * @var string authentication method type
     */
    protected $type;

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (isset($this->type)) {
            $this->validateAuthType();
        } else {
            $this->determineAuthType();
        }
    }

    /**
     * Checks that specified authentication method exists and all needed parameters are specified.
     * @throws InvalidConfigException
     */
    protected function validateAuthType()
    {
        $methods = static::getMethods();
        // check that specified authentication method exists
        if (!array_key_exists($this->type, $methods)) {
            throw new InvalidConfigException("Unknown authentication method.\n" . static::getMethodsInfo());
        }

        // check that all needed parameters are specified
        $requiredFields = $methods[$this->type]['required'];
        foreach ($requiredFields as $field) {
            if (!isset($this->$field)) {
                throw new InvalidConfigException(
                    $this->type . ' authentication method requires the following data: "' .
                    implode('", "', $requiredFields) . '".'
                );
            }
        }
    }

    /**
     * Determine authentication method type automatically.
     * @throws InvalidConfigException
     */
    protected function determineAuthType()
    {
        foreach (static::getMethods() as $type => $method) {
            foreach ($method['required'] as $field) {
                if (!isset($this->$field)) {
                    continue 2;
                }
            }
            $this->type = $type;
            break;
        }
        if (!isset($this->type)) {
            throw new InvalidConfigException("Can't determine authentication method.\n" . static::getMethodsInfo());
        }
    }

    /**
     * Get authentication method type.
     * @return string authentication method type.
     */
    public function getAuthType()
    {
        return $this->type;
    }

    /**
     * Lists authentication methods.
     * @return array authentication methods.
     */
    public static function getMethods()
    {
        return [
            static::SINGLE_SIGN_ON => [
                'required' => ['username', 'password', 'targetUsername'],
                'services' => [Cpanel::API_2, Cpanel::UAPI, Cpanel::WHM_API_0, Cpanel::WHM_API_1],
            ],
            static::USERNAME_PASSWORD => [
                'required' => ['username', 'password'],
                'services' => [Cpanel::API_2, Cpanel::UAPI, Cpanel::WHM_API_0, Cpanel::WHM_API_1],
            ],
            static::HASH => [
                'required' => ['hash'],
                'services' => [Cpanel::API_2, Cpanel::WHM_API_0, Cpanel::WHM_API_1],
            ],
        ];
    }

    /**
     * Returns information about authentication methods.
     * @return string information about authentication methods.
     */
    public static function getMethodsInfo()
    {
        $message[] = 'Allowed authentication methods:';
        foreach (static::getMethods() as $type => $method) {
            $message[] = ' - ' . $type . ': requires "' . implode('", "', $method['required']) . '", allows to use ' .
                implode(', ', $method['services']);
        }
        return implode("\n", $message);
    }
}
