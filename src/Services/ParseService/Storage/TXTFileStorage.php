<?php

namespace Dykyi\Services\ParseService\Storage;

/**
 * Class TXTFileStorage
 * @package Dykyi\Services\ParseService\Storage
 */
class TXTFileStorage implements FileStorageInterface
{
    public function save(string $fileName, array $data): bool
    {
        //TODO: save logic
        return true;
    }
}