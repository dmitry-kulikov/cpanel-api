<?php

namespace kdn\cpanel\api\modules;

use kdn\cpanel\api\Cpanel;
use kdn\cpanel\api\exceptions\Exception;
use kdn\cpanel\api\Module;
use kdn\cpanel\api\responses\Api2Response;

/**
 * Class Api2Module.
 * @package kdn\cpanel\api\modules
 * @method Api2Response get($function, $params = [], $body = null, $requestOptions = [])
 * @method Api2Response post($function, $params = [], $body = null, $requestOptions = [])
 */
abstract class Api2Module extends Module
{
    /**
     * @inheritdoc
     */
    protected $port = 2087;

    /**
     * @inheritdoc
     */
    protected $serviceName = Cpanel::API_2;

    /**
     * @var string the cPanel username for the account through which to call the API 2 function
     */
    protected $targetUsername;

    /**
     * @inheritdoc
     */
    protected $responseClass = 'kdn\cpanel\api\responses\Api2Response';

    /**
     * Get the cPanel username for the account through which to call the API 2 function.
     * @return string the cPanel username for the account through which to call the API 2 function.
     */
    public function getTargetUsername()
    {
        return $this->targetUsername;
    }

    /**
     * Set the cPanel username for the account through which to call the API 2 function.
     * @param string $targetUsername the cPanel username for the account through which to call the API 2 function
     * @return $this module.
     */
    public function setTargetUsername($targetUsername)
    {
        $this->targetUsername = $targetUsername;
        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function buildUri($function, $params)
    {
        $targetUsername = $this->getTargetUsername();
        if (!isset($targetUsername)) {
            throw new Exception('Target username must be specified.');
        }
        $params['api.version'] = 1;
        $params['cpanel_jsonapi_user'] = mb_strtolower($targetUsername);
        $params['cpanel_jsonapi_module'] = $this->getName();
        $params['cpanel_jsonapi_func'] = $function;
        $params['cpanel_jsonapi_apiversion'] = 2;
        return $this->getBaseUri()->withPath('json-api/cpanel')->withQuery(static::buildQuery($params));
    }
}
