<?php

namespace kdn\cpanel\api\modules\uapi;

use kdn\cpanel\api\modules\UapiModule;

/**
 * Class Ssl.
 * @package kdn\cpanel\api\modules\uapi
 */
class Ssl extends UapiModule
{
    /**
     * @inheritdoc
     */
    protected $name = 'SSL';

    /**
     * @link https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+SSL%3A%3Ainstall_ssl
     * @param string $domain
     * @param string $certificate
     * @param string $privateKey
     * @param null|string $caBundle
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function installSsl($domain, $certificate, $privateKey, $caBundle = null)
    {
        $formParams = [
            'domain' => $domain,
            'cert' => $certificate,
            'key' => $privateKey,
        ];
        if (isset($caBundle)) {
            $formParams['cabundle'] = $caBundle;
        }
        return $this->post('install_ssl', [], null, ['form_params' => $formParams]);
    }

    /**
     * @see Ssl::installSsl
     * @param string $domain
     * @param string $certificateFile
     * @param string $privateKeyFile
     * @param null|string $caBundleFile
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function installSslFromFiles($domain, $certificateFile, $privateKeyFile, $caBundleFile = null)
    {
        $certificate = static::getFileContents($certificateFile);
        $privateKey = static::getFileContents($privateKeyFile);
        $caBundle = isset($caBundleFile) ? static::getFileContents($caBundleFile) : null;
        return $this->installSsl($domain, $certificate, $privateKey, $caBundle);
    }

    /**
     * @link https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+SSL%3A%3Alist_certs
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function listCerts()
    {
        return $this->get('list_certs');
    }

    /**
     * @link https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+SSL%3A%3Adelete_cert
     * @param string $id
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function deleteCertById($id)
    {
        return $this->post('delete_cert', [], null, ['form_params' => ['id' => $id]]);
    }

    /**
     * @link https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+SSL%3A%3Adelete_cert
     * @param string $friendlyName
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function deleteCertByName($friendlyName)
    {
        return $this->post('delete_cert', [], null, ['form_params' => ['friendly_name' => $friendlyName]]);
    }

    /**
     * @link https://documentation.cpanel.net/display/SDK/UAPI+Functions+-+SSL%3A%3Aset_cert_friendly_name
     * @param string $friendlyName
     * @param string $newFriendlyName
     * @return \kdn\cpanel\api\responses\UapiResponse parsed response to request.
     */
    public function setCertFriendlyName($friendlyName, $newFriendlyName)
    {
        $formParams = ['friendly_name' => $friendlyName, 'new_friendly_name' => $newFriendlyName];
        return $this->post('set_cert_friendly_name', [], null, ['form_params' => $formParams]);
    }

    /**
     * Reads entire file into a string.
     * @param string $fileName name of the file to read
     * @return boolean|string returns the read data or false on failure.
     */
    protected static function getFileContents($fileName)
    {
        return file_get_contents(realpath($fileName));
    }
}
