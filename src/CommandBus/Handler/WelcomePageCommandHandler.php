<?php

namespace Dykyi\CommandBus\Handler;

use Symfony\Component\HttpFoundation\Response;
use SimpleBus\Command\Command;
use SimpleBus\Command\Handler\CommandHandler;

/**
 * Class WelcomePageCommandHandler
 * @package Dykyi\Command\Handler
 */
class WelcomePageCommandHandler extends Handler implements CommandHandler
{
    /**
     * @param Command $command
     */
    public function handle(Command $command)
    {
        $content = $this->getResponse()->add('')
            ->add("**************************************************")
            ->add("************ Welcome to Application **************")
            ->add("**************************************************")
            ->add('')
            ->add('Usage:')->add("command [options]", 2)
            ->add('')
            ->add('Available commands:')
            ->add("Version  - Application version", 2)
            ->add("Parse    - Parse website by url", 2)
            ->add('')
            ->add("**************************************************");

        $contentFormat = $this->getFormatter()->format($content);
        $response = new Response($contentFormat);
        $response->send();
    }
}