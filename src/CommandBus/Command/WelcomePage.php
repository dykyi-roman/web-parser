<?php

namespace Dykyi\CommandBus\Command;

use SimpleBus\Command\Command;

/**
 * Class WelcomePage
 * @package Dykyi\Command
 */
class WelcomePage implements Command
{
    /**
     * @return string
     */
    public function name()
    {
        return __CLASS__;
    }
}