<?php

namespace Dykyi\Services\Events;

use Dykyi\Services\Events\Event\SaveFileInTheStorageEvent;
use Dykyi\Services\ParseService\Storage\Storage;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class Listener
 * @package Dykyi\Services\Events
 */
class Listener implements LoggerAwareInterface
{
    /** @var LoggerInterface|NullLogger  */
    protected $logger;

    /**
     * @param SaveFileInTheStorageEvent $event
     */
    public function onSaveReport(SaveFileInTheStorageEvent $event)
    {
        $storage = Storage::create($event->getFileFormat());
        $storage->save($event->getFileName().'.'.$event->getFileFormat(), $event->getData());
        $this->logger->info('File is saving');
    }

    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger ?? new NullLogger();
    }
}