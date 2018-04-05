<?php

namespace Dykyi\CommandBus\Handler;

use Dykyi\CommandBus\Command\Parse;
use Dykyi\Services\ParseService\ParseRequest;
use Dykyi\Services\ParseService\ParseService;
use Stash\Driver\FileSystem;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ParseCommandHandler
 * @package Dykyi\Command\Handler
 */
class ParseCommandHandler
{
    /**
     * @param Parse $command
     * @throws \Throwable
     */
    public function handle(Parse $command)
    {
        try {
            $request = new ParseRequest($command->getUrl());
            $service = new ParseService(new FileSystem());
            $service->execute($request);
        } catch (\InvalidArgumentException $exception) {
            $response = new Response($exception->getMessage());
            $response->send();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}