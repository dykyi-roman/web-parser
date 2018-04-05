<?php

namespace Dykyi\Services\Events;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class Dispatcher
 * @package Dykyi\CommandBus\Events
 */
final class Dispatcher
{
    /**
     * @param LoggerInterface $logger
     *
     * @return EventDispatcher
     */
    public static function create(LoggerInterface $logger = null)
    {
        $eventDispatcher = new EventDispatcher();
        $listener = new Listener();
        $listener->setLogger($logger);

        $eventDispatcher->addListener('save.file.action', [$listener, 'onSaveReport']);
        // Add your action here!

        $subscriber = new Subscriber();
        $eventDispatcher->addSubscriber($subscriber);

        return $eventDispatcher;
    }
}