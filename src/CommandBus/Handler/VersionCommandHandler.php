<?php

namespace Dykyi\CommandBus\Handler;

use Dykyi\CommandBus\Command\Version;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class VersionCommandHandler
 * @package Dykyi\Command\Handler
 */
class VersionCommandHandler extends Handler
{
    /**
     * @param Version $command
     */
    public function handle(Version $command)
    {
        $content = $this->getResponse()->add("Application version: " . $command::VERSION_ID);
        $contentFormat = $this->getFormatter()->format($content);

        $response = new Response($contentFormat);
        $response->send();
    }
}