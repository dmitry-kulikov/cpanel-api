<?php

namespace kdn\cpanel\api;

/**
 * Class HistoryContainer.
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
        return end($this->historyContainer)['request'];
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
