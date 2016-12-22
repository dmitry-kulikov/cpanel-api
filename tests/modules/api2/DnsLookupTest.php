<?php

namespace kdn\cpanel\api\modules\api2;

use kdn\cpanel\api\responses\Api2Response;

/**
 * Class DnsLookupTest.
 * @package kdn\cpanel\api\modules\api2
 * @property \kdn\cpanel\api\modules\api2\DnsLookup $module
 * @covers \kdn\cpanel\api\modules\Api2Module
 * @uses   \kdn\cpanel\api\Object
 * @uses   \kdn\cpanel\api\ServiceLocator
 * @uses   \kdn\cpanel\api\Cpanel
 * @uses   \kdn\cpanel\api\Auth
 * @uses   \kdn\cpanel\api\Api
 * @uses   \kdn\cpanel\api\apis\Api2
 * @uses   \kdn\cpanel\api\Module
 * @uses   \kdn\cpanel\api\Response
 * @uses   \kdn\cpanel\api\responses\Api2Response
 */
class DnsLookupTest extends Api2ModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $moduleName = 'dnsLookup';

    /**
     * @covers \kdn\cpanel\api\modules\api2\DnsLookup::name2ip
     * @medium
     */
    public function testName2Ip()
    {
        $domain = static::getCpanelHost();
        $this->assertInstanceOf(Api2Response::className(), $this->module->name2ip($domain));
        $request = $this->getLastRequest();
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getWhmHost() . ':' . static::getWhmPort() . '/json-api/cpanel?domain=' . $domain .
            '&api.version=1&cpanel_jsonapi_user=' . static::getCpanelAuthUsername() .
            '&cpanel_jsonapi_module=DnsLookup&cpanel_jsonapi_func=name2ip&cpanel_jsonapi_apiversion=2',
            (string)$request->getUri()
        );
    }
}
