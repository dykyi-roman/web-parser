<?php

namespace Dykyi\App;

use Dykyi\CommandBus\CommandBus;
use Dykyi\ValueObjects\CommandInput;

/**
 * Class Cli Application
 * @package Dykyi
 */
final class Application
{
    const APP_CLI = 'cli';

    /**
     * Application constructor.
     * @param string $sapi
     */
    public function __construct(string $sapi)
    {
        if ($sapi !== self::APP_CLI)
        {
            exit('Sorry this is CLI Application! Use a command Line for run this application.');
        }
    }

    public function run()
    {
        $input = new CommandInput();
        $commandBus = CommandBus::create();
        $command = $commandBus->getCommandByInput($input);
        $commandBus->handle($command);
    }
}