<?php

namespace kdn\cpanel\api\modules\api2;

use kdn\cpanel\api\modules\Api2Module;

/**
 * Class DnsLookup.
 * @package kdn\cpanel\api\modules\api2
 */
class DnsLookup extends Api2Module
{
    /**
     * @inheritdoc
     */
    protected $name = 'DnsLookup';

    /**
     * @link https://documentation.cpanel.net/display/SDK/cPanel+API+2+Functions+-+DnsLookup%3A%3Aname2ip
     * @param string $domain
     * @return \kdn\cpanel\api\responses\Api2Response parsed response to request.
     */
    public function name2ip($domain)
    {
        return $this->get('name2ip', ['domain' => $domain]);
    }
}
