<?php

namespace Dykyi\Services\ParseService\Storage;

use Dykyi\Services\ParseService\Exception\StorageNotFound;

/**
 * Class Storage
 * @package Dykyi\Services\ParseService\Clients
 */
class Storage
{
    /**
     * @param string $fileFormat
     * @return FileStorageInterface
     */
    public static function create(string $fileFormat): FileStorageInterface
    {
        $class = __NAMESPACE__ . '\\' . strtoupper($fileFormat).'FileStorage';

        if (!class_exists($class)) {
            throw StorageNotFound::forMessage($fileFormat);
        }

        return new $class();
    }
}