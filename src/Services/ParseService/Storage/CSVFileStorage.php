<?php

namespace Dykyi\Services\ParseService\Storage;

/**
 * Class CSVFileRepository
 * @package Dykyi\Services\ParseService\Clients
 */
class CSVFileStorage implements FileStorageInterface
{
    public function save(string $fileName, array $data): bool
    {
        //TODO: save logic
        return true;
    }
}