<?php

namespace kdn\cpanel\api\modules\uapi;

use kdn\cpanel\api\responses\UapiResponse;

/**
 * Class SslTest.
 * @package kdn\cpanel\api\modules\uapi
 * @property \kdn\cpanel\api\modules\uapi\Ssl $module
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
class SslTest extends UapiModuleTestCase
{
    /**
     * @inheritdoc
     */
    protected $moduleName = 'ssl';

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Ssl::listCerts
     * @medium
     */
    public function testListCerts()
    {
        $this->assertInstanceOf(UapiResponse::className(), $this->module->listCerts());
        $request = $this->getLastRequest();
        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':' . static::getCpanelPort() . '/execute/SSL/list_certs',
            (string)$request->getUri()
        );
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Ssl::installSsl
     * @medium
     */
    public function testInstallSsl()
    {
        $domain = static::getCpanelDomain();
        $response = $this->module->installSsl($domain, 'certificate', 'privateKey', 'caBundle');
        $this->assertInstanceOf(UapiResponse::className(), $response);
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':' . static::getCpanelPort() . '/execute/SSL/install_ssl',
            (string)$request->getUri()
        );
        $this->assertEquals(
            "domain=$domain&cert=certificate&key=privateKey&cabundle=caBundle",
            $request->getBody()->getContents()
        );
    }

    public function installSslFromFilesExceptionProvider()
    {
        $relativePath = static::getDataPath() . 'ssl';
        $fileNames = ['cert.pem', 'privkey.pem', 'bundle.txt'];
        $filePaths = [];
        foreach ($fileNames as $fileName) {
            $filePaths[] = "$relativePath/$fileName";
        }
        $fileNamesCount = count($fileNames);
        $data = [];
        for ($i = 0; $i < $fileNamesCount; $i++) {
            $dataSet = $filePaths;
            $dataSet[$i] = "$relativePath/not-existing";
            $data["not existing {$fileNames[$i]}"] = $dataSet;
        }
        return $data;
    }

    /**
     * @param string $certificateFile
     * @param string $privateKeyFile
     * @param string $caBundleFile
     * @covers       \kdn\cpanel\api\modules\uapi\Ssl::getFileContents
     * @covers       \kdn\cpanel\api\modules\uapi\Ssl::installSslFromFiles
     * @uses         \kdn\cpanel\api\modules\uapi\Ssl::installSsl
     * @dataProvider installSslFromFilesExceptionProvider
     * @expectedException \kdn\cpanel\api\exceptions\Exception
     * @expectedExceptionMessage Unable to read file
     * @small
     */
    public function testInstallSslFromFilesException($certificateFile, $privateKeyFile, $caBundleFile)
    {
        $this->module->installSslFromFiles(static::getCpanelDomain(), $certificateFile, $privateKeyFile, $caBundleFile);
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Ssl::getFileContents
     * @covers \kdn\cpanel\api\modules\uapi\Ssl::installSslFromFiles
     * @uses   \kdn\cpanel\api\modules\uapi\Ssl::installSsl
     * @medium
     */
    public function testInstallSslFromFiles()
    {
        $domain = static::getCpanelDomain();
        $relativePath = static::getDataPath() . 'ssl';
        $response = $this->module->installSslFromFiles(
            $domain,
            "$relativePath/cert.pem",
            "$relativePath/privkey.pem",
            "$relativePath/bundle.txt"
        );
        $this->assertInstanceOf(UapiResponse::className(), $response);
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':' . static::getCpanelPort() . '/execute/SSL/install_ssl',
            (string)$request->getUri()
        );
        $this->assertEquals(
            "domain=$domain&cert=certificate&key=privateKey&cabundle=caBundle",
            $request->getBody()->getContents()
        );
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Ssl::deleteCertById
     * @medium
     */
    public function testDeleteCertById()
    {
        $certId = 'example_com_cb497_a394d_1397249671_d1272da8f13a1fd837493a5ad1f0a0f3';
        $this->assertInstanceOf(UapiResponse::className(), $this->module->deleteCertById($certId));
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':' . static::getCpanelPort() . '/execute/SSL/delete_cert',
            (string)$request->getUri()
        );
        $this->assertEquals("id=$certId", $request->getBody()->getContents());
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Ssl::deleteCertByName
     * @medium
     */
    public function testDeleteCertByName()
    {
        $certName = 'TestCert';
        $this->assertInstanceOf(UapiResponse::className(), $this->module->deleteCertByName($certName));
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':' . static::getCpanelPort() . '/execute/SSL/delete_cert',
            (string)$request->getUri()
        );
        $this->assertEquals("friendly_name=$certName", $request->getBody()->getContents());
    }

    /**
     * @covers \kdn\cpanel\api\modules\uapi\Ssl::setCertFriendlyName
     * @medium
     */
    public function testSetCertFriendlyName()
    {
        $certName = 'TestCert';
        $newCertName = 'TestCert2';
        $this->assertInstanceOf(UapiResponse::className(), $this->module->setCertFriendlyName($certName, $newCertName));
        $request = $this->getLastRequest();
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals(
            'https://' . static::getCpanelHost() . ':' . static::getCpanelPort() .
            '/execute/SSL/set_cert_friendly_name',
            (string)$request->getUri()
        );
        $this->assertEquals(
            "friendly_name=$certName&new_friendly_name=$newCertName",
            $request->getBody()->getContents()
        );
    }
}
