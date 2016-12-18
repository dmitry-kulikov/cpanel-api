<?php

namespace kdn\cpanel\api\modules\uapi;

use kdn\cpanel\api\modules\UapiModule;

/**
 * Class Bandwidth.
 * @package kdn\cpanel\api\modules\uapi
 */
class Bandwidth extends UapiModule
{
    /**
     * @inheritdoc
     */
    protected $name = 'Bandwidth';

    /**
     * @link https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Bandwidth%3A%3Aget_retention_periods
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function getRetentionPeriods()
    {
        return $this->get('get_retention_periods');
    }

    /**
     * @link https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Bandwidth%3A%3Aquery
     * @param string|array $grouping
     * @param null|string $interval
     * @param null|string|array $domains
     * @param null|string|array $protocols
     * @param null|integer $start
     * @param null|integer $end
     * @param null|string $timezone
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function query(
        $grouping,
        $interval = null,
        $domains = null,
        $protocols = null,
        $start = null,
        $end = null,
        $timezone = null
    ) {
        $arrayParams = ['grouping', 'domains', 'protocols'];
        foreach ($arrayParams as $paramName) {
            if (is_array($$paramName)) {
                if (empty($$paramName)) {
                    $$paramName = null;
                } else {
                    $$paramName = implode('|', $$paramName);
                }
            }
        }
        $params = [
            'grouping' => $grouping,
            'interval' => $interval,
            'domains' => $domains,
            'protocols' => $protocols,
            'start' => $start,
            'end' => $end,
            'timezone' => $timezone,
        ];
        array_filter(
            $params,
            function ($var) {
                return isset($var);
            }
        );
        return $this->get('query', $params);
    }
}
