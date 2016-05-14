<?php

namespace kdn\cpanel\api;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use kdn\cpanel\api\exceptions\AuthMethodNotSupportedException;
use kdn\cpanel\api\exceptions\InvalidAuthMethodException;
use Psr\Http\Message\RequestInterface;

/**
 * Class Module.
 * @package kdn\cpanel\api
 */
abstract class Module extends Object
{
    /**
     * @var Cpanel Cpanel object
     */
    public $cpanel;

    /**
     * @var string cPanel host
     */
    protected $host;

    /**
     * @var string protocol which should be used to perform requests
     */
    protected $protocol;

    /**
     * @var integer port which should be used to perform requests
     */
    protected $port;

    /**
     * @var Auth authentication method object
     */
    protected $auth;

    /**
     * @var Client GuzzleHttp client object
     */
    protected $client;

    /**
     * @var string module name
     */
    protected $name;

    /**
     * @var string service name
     */
    protected $serviceName;

    /**
     * @var string response object class
     */
    protected $responseClass;

    /**
     * Get GuzzleHttp client object.
     * @return Client GuzzleHttp client object.
     */
    public function getClient()
    {
        if (!isset($this->client)) {
            $this->client = new Client;
        }
        return $this->client;
    }

    /**
     * Set GuzzleHttp client object.
     * @param Client $client GuzzleHttp client object
     * @return $this module.
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Get base URI.
     * @return Uri base URI address.
     */
    public function getBaseUri()
    {
        return (new Uri)
            ->withScheme($this->getProtocol())
            ->withHost($this->getHost())
            ->withPort($this->getPort());
    }

    /**
     * Get cPanel host.
     * @return string cPanel host.
     */
    public function getHost()
    {
        if (isset($this->host)) {
            return $this->host;
        } else {
            return $this->cpanel->host;
        }
    }

    /**
     * Set cPanel host.
     * @param string $host cPanel host
     * @return $this module.
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * Get protocol which should be used to perform requests.
     * @return string protocol which should be used to perform requests.
     */
    public function getProtocol()
    {
        if (isset($this->protocol)) {
            return $this->protocol;
        } else {
            return $this->cpanel->protocol;
        }
    }

    /**
     * Set protocol which should be used to perform requests.
     * @param string $protocol protocol which should be used to perform requests
     * @return $this module.
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
        return $this;
    }

    /**
     * Get port which should be used to perform requests.
     * @return integer port which should be used to perform requests.
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set port which should be used to perform requests.
     * @param integer $port port which should be used to perform requests
     * @return $this module.
     */
    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    /**
     * Get authentication method object.
     * @return Auth authentication method object.
     */
    public function getAuth()
    {
        if (isset($this->auth)) {
            return $this->auth;
        } else {
            return $this->cpanel->auth;
        }
    }

    /**
     * Set authentication method object.
     * @param Auth $auth authentication method object
     * @return $this module.
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;
        return $this;
    }

    /**
     * Get module name.
     * @return string module name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get service name.
     * @return string service name.
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * Returns new GuzzleHttp request object.
     * @param string $method HTTP method for the request
     * @param string|\Psr\Http\Message\UriInterface $uri URI for the request
     * @param array $headers headers for the message
     * @param string|resource|\Psr\Http\Message\StreamInterface $body message body
     * @param string $protocolVersion HTTP protocol version
     * @return Request new GuzzleHttp request object.
     */
    public static function createRequest($method, $uri, array $headers = [], $body = null, $protocolVersion = '1.1')
    {
        return new Request($method, $uri, $headers, $body, $protocolVersion);
    }

    /**
     * Send an HTTP request.
     * @param RequestInterface $request request to send
     * @param array $options request options to apply to the given request and to the transfer
     * @return \Psr\Http\Message\ResponseInterface response to request.
     */
    public function sendRequest(RequestInterface $request, array $options = [])
    {
        return $this->getClient()->send($request, $options);
    }

    /**
     * Create and send an HTTP GET request to call function with specified parameters.
     * @param string $function function name
     * @param array $params parameters
     * @param string|resource|\Psr\Http\Message\StreamInterface $body message body
     * @param array $requestOptions request options to apply to the given request and to the transfer
     * @return Response parsed response to request.
     */
    public function get($function, $params = [], $body = null, $requestOptions = [])
    {
        return $this->send('get', $function, $params, $body, $requestOptions);
    }

    /**
     * Create and send an HTTP POST request to call function with specified parameters.
     * @param string $function function name
     * @param array $params parameters
     * @param string|resource|\Psr\Http\Message\StreamInterface $body message body
     * @param array $requestOptions request options to apply to the given request and to the transfer
     * @return Response parsed response to request.
     */
    public function post($function, $params = [], $body = null, $requestOptions = [])
    {
        return $this->send('post', $function, $params, $body, $requestOptions);
    }

    /**
     * Create and send an HTTP request to call function with specified parameters.
     * @param string $method HTTP method for the request
     * @param string $function function name
     * @param array $params parameters
     * @param string|resource|\Psr\Http\Message\StreamInterface $body message body
     * @param array $requestOptions request options to apply to the given request and to the transfer
     * @return Response parsed response to request.
     * @throws AuthMethodNotSupportedException
     * @throws InvalidAuthMethodException
     */
    public function send($method, $function, $params = [], $body = null, $requestOptions = [])
    {
        $this->validateAuthType();
        $request = static::createRequest($method, $this->buildUri($function, $params), $this->buildHeaders(), $body);
        /** @var Response $response */
        $response = new $this->responseClass($this->sendRequest($request, $requestOptions));
        return $response->parse();
    }

    /**
     * Checks that current authentication method can be used with current service.
     * @throws AuthMethodNotSupportedException
     * @throws InvalidAuthMethodException
     */
    protected function validateAuthType()
    {
        $auth = $this->getAuth();
        if (!is_object($auth)) {
            throw new InvalidAuthMethodException('The authentication method must be an object.');
        }
        $authType = $auth->getAuthType();
        if (!in_array($this->getServiceName(), $auth->getMethods()[$authType]['services'])) {
            throw new AuthMethodNotSupportedException(
                'Authentication method "' . $authType . '" not supported by service "' . $this->getServiceName() .
                '".' . "\n" . $auth->getMethodsInfo()
            );
        }
    }

    /**
     * Builds URI address for request.
     * @param string $function function name
     * @param array $params parameters
     * @return Uri URI address.
     */
    abstract protected function buildUri($function, $params);

    /**
     * Builds headers for request.
     * @return array headers for request.
     */
    protected function buildHeaders()
    {
        $headers = [];
        $auth = $this->getAuth();
        switch ($auth->getAuthType()) {
            case Auth::USERNAME_PASSWORD:
                $headers['Authorization'] = 'Basic ' . base64_encode("$auth->username:$auth->password");
                break;
            case Auth::HASH:
                $headers['Authorization'] = 'WHM root:' . preg_replace("'(\r|\n)'", '', $auth->hash);
                break;
        }
        return $headers;
    }

    /**
     * Build a query string from an array of key value pairs.
     * @param array $params query string parameters
     * @param integer $encoding by default, PHP_QUERY_RFC3986;
     * if encoding is PHP_QUERY_RFC1738, then encoding is performed per
     * RFC 1738 and the application/x-www-form-urlencoded media type,
     * which implies that spaces are encoded as plus (+) signs;
     * if encoding is PHP_QUERY_RFC3986, then encoding is performed according to
     * RFC 3986, and spaces will be percent encoded (%20)
     * @return string a URL-encoded query string.
     */
    public static function buildQuery(array $params, $encoding = PHP_QUERY_RFC3986)
    {
        return http_build_query($params, null, '&', $encoding);
    }
}
