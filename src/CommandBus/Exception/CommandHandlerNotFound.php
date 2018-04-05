<?php

namespace Dykyi\CommandBus\Exception;

/**
 * Class CommandHandlerNotFound
 * @package Dykyi\Command\Exception
 */
class CommandHandlerNotFound extends \LogicException
{
    /**
     * @param $exceptionMessage
     * @return CommandHandlerNotFound
     */
    public static function forMessage(string $exceptionMessage)
    {
        return new self(
            sprintf(
                'Could not determine handler for the command "%s"',
                $exceptionMessage
            )
        );
    }
}