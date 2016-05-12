<?php

namespace kdn\cpanel\api;

use Symfony\Component\Serializer\Encoder\JsonEncoder;

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
     */
    public function parse()
    {
        if ($this->isParsed()) {
            return $this;
        }
        $encoder = new JsonEncoder();
        $decodedResponse = $encoder->decode($this->rawResponse->getBody()->getContents(), $encoder::FORMAT);
        $this->parsed = true;
        $this->denormalize($decodedResponse);
        return $this;
    }

    /**
     * Uses response data array to set response object properties.
     * @param array $data response data
     */
    abstract protected function denormalize($data);
}
