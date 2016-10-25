<?php

namespace kdn\cpanel\api\modules\uapi;

use DateInterval;
use DateTime;
use kdn\cpanel\api\responses\UapiResponse;

/**
 * Class BandwidthTest.
 * @package kdn\cpanel\api\modules\uapi
 * @property \kdn\cpanel\api\modules\uapi\Bandwidth $module
 * @covers \kdn\cpanel\api\modules\UapiModule
 * @uses   \kdn\cpanel\api\Object
 * @uses   \kdn\cpanel\api\ServiceLocator
 * @uses   \kdn\cpanel\api\Cpanel
 * @uses   \kdn\cpanel\api\Auth
 * @uses   \kdn\cpanel\api\Api
 * @uses   \kdn\cpanel\api\apis\Uapi
 * @uses   \kdn\cpanel\api\Module
 * @uses   \kdn\cpanel\api\Response
 * @uses   \kdn\cpanel\api\responses\UapiResponse
 */
class BandwidthTest extends UapiModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $moduleName = 'bandwidth';

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Bandwidth::getRetentionPeriods
     * @medium
     */
    public function testGetRetentionPeriods()
    {
        $this->assertInstanceOf(UapiResponse::className(), $this->module->getRetentionPeriods());
        $request = $this->getLastRequest();
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':2083/execute/Bandwidth/get_retention_periods',
            (string)$request->getUri()
        );
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Bandwidth::query
     * @medium
     */
    public function testQuery()
    {
        $response = $this->module->query('domain', null, []);
        $this->assertInstanceOf(UapiResponse::className(), $response);
        $request = $this->getLastRequest();
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':2083/execute/Bandwidth/query?grouping=domain',
            (string)$request->getUri()
        );
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Bandwidth::query
     * @medium
     */
    public function testQueryAdvanced()
    {
        $end = new DateTime();
        $start = clone $end;
        $start->sub(new DateInterval('P2M'));
        $startTimestamp = $start->getTimestamp();
        $endTimestamp = $end->getTimestamp();
        $cpanelDomain = static::getCpanelDomain();
        $response = $this->module->query(
            ['domain', 'protocol', 'year_month'],
            'daily',
            [$cpanelDomain, 'UNKNOWN'],
            ['http', 'imap', 'smtp', 'pop3', 'ftp'],
            $startTimestamp,
            $endTimestamp,
            'America/Chicago'
        );
        $this->assertInstanceOf(UapiResponse::className(), $response);
        $request = $this->getLastRequest();
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':2083/execute/Bandwidth/query?' .
            "grouping=domain%7Cprotocol%7Cyear_month&interval=daily&domains=$cpanelDomain%7CUNKNOWN&" .
            'protocols=http%7Cimap%7Csmtp%7Cpop3%7Cftp&' .
            "start=$startTimestamp&end=$endTimestamp&timezone=America%2FChicago",
            (string)$request->getUri()
        );
    }
}
