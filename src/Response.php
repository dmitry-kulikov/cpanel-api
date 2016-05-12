<?php

namespace kdn\cpanel\api;

use kdn\cpanel\api\exceptions\InvalidJsonException;

/**
 * Class Response.
 * @package kdn\cpanel\api
 */
abstract class Response extends Object
{
    /**
     * @var \Psr\Http\Message\ResponseInterface raw response object from GuzzleHttp
     */
    protected $rawResponse;

    /**
     * @var boolean whether response was parsed
     */
    protected $parsed = false;

    /**
     * Response constructor.
     * @param \Psr\Http\Message\ResponseInterface $response raw response object from GuzzleHttp
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($response, $config = [])
    {
        parent::__construct($config);
        $this->rawResponse = $response;
    }

    /**
     * Returns whether response was parsed.
     * @return boolean whether response was parsed.
     */
    public function isParsed()
    {
        return $this->parsed;
    }

    /**
     * Parse response.
     * @return $this parsed response object.
     * @throws InvalidJsonException
     */
    public function parse()
    {
        if ($this->isParsed()) {
            return $this;
        }
        $decodedResponse = json_decode($this->rawResponse->getBody()->getContents(), true);
        $this->parsed = true;
        $jsonLastError = JsonHelper::getJsonLastError();
        if (isset($jsonLastError)) {
            throw new InvalidJsonException("Invalid JSON: $jsonLastError.");
        }
        foreach ($this->getParams() as $param) {
            $this->$param = $decodedResponse[$param];
        }
        return $this;
    }

    /**
     * Get response parameter names.
     * @return array response parameter names.
     */
    abstract protected function getParams();
}
