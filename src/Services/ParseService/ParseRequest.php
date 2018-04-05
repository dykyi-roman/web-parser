<?php

namespace Dykyi\Services\ParseService;

use Dykyi\ValueObjects\Url;

/**
 * Class ParseRequest
 * @package Dykyi\Services\ParseService
 */
class ParseRequest
{
    /** @var Url */
    private $url;

    /**
     * ParseRequest constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = new Url($url);
    }

    /**
     * @return Url
     */
    public function getUrl(): Url
    {
        return $this->url;
    }
}