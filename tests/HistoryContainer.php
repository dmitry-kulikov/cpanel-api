<?php

namespace kdn\cpanel\api;

/**
 * Trait HistoryContainer.
 * @package kdn\cpanel\api
 */
trait HistoryContainer
{
    /**
     * @var array container which holds the history of requests
     */
    protected $historyContainer;

    /**
     * Clear container.
     */
    protected function clearHistoryContainer()
    {
        $this->historyContainer = [];
    }

    /**
     * Get last request from container.
     * @return \GuzzleHttp\Psr7\Request last request.
     */
    protected function getLastRequest()
    {
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = end($this->historyContainer)['request'];
        $request->getBody()->rewind();
        return $request;
    }

    /**
     * Get last request options from container.
     * @return array last request options.
     */
    protected function getLastRequestOptions()
    {
        return end($this->historyContainer)['options'];
    }
}
