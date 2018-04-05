<?php

namespace Dykyi\Services\Events\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class SaveFileInTheStorageEvent
 * @package Dykyi\Services\Events\Event
 */
class SaveFileInTheStorageEvent extends Event
{
    private $fileFormat;
    private $fileName;
    private $data;

    public function __construct(string $fileFormat, string $fileName, array $data)
    {
        $this->fileFormat  = $fileFormat;
        $this->fileName = $fileName;
        $this->data = $data;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getFileFormat(): string
    {
        return $this->fileFormat;
    }

    public function getData(): array
    {
        return $this->data;
    }

}