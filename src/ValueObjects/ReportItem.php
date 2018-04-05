<?php

namespace Dykyi\ValueObjects;

/**
 * Class ReportItem
 * @package Dykyi\ValueObjects
 */
class ReportItem
{
    private $url;
    private $tagCount;
    private $processingTime;

    public function __construct(string $url, int $tagCount, float $processingTime)
    {
        $this->url = $url;
        $this->tagCount = $tagCount;
        $this->processingTime = $processingTime;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getTagCount()
    {
        return $this->tagCount;
    }

    public function getProcessingTime()
    {
        return $this->processingTime;
    }

}