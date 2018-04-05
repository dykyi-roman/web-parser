<?php

namespace Dykyi\CommandBus\Command;

use SimpleBus\Command\Command;

/**
 * Class Version
 * @package Dykyi\Command
 */
class Version implements Command
{
    const VERSION_ID = '1.0';
    /**
     * @return string
     */
    public function name()
    {
        return __CLASS__;
    }
}