<?php

namespace kdn\cpanel\api\modules\uapi;

use kdn\cpanel\api\modules\UapiModule;

/**
 * Class Batch.
 * @package kdn\cpanel\api\modules\uapi
 */
class Batch extends UapiModule
{
    /**
     * @inheritdoc
     */
    protected $name = 'Batch';

    /**
     * @link https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+Batch%3A%3Astrict
     * @param string|array $command
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function strict($command)
    {
        if (!is_array($command)) {
            $formParams = ['command-0' => $command];
        } else {
            $formParams = [];
            foreach ($command as $key => $value) {
                if (!is_string($key)) {
                    $key = "command-$key";
                }
                $formParams[$key] = $value;
            }
            ksort($formParams);
        }
        return $this->post('strict', [], null, ['form_params' => $formParams]);
    }
}
