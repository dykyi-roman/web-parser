<?php

namespace Dykyi\CommandBus\Command;

use SimpleBus\Command\Command;

/**
 * Class Parse
 * @package Dykyi\Command
 */
class Parse implements Command
{
    private $url;

    /**
     * Parse constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        if (empty($url)) {
            throw new \InvalidArgumentException('Missing required "url" parameter');
        }

        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function name()
    {
        return __CLASS__;
    }
}