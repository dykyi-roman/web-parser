<?php

namespace Dykyi\Services\ParseService\Storage;

/**
 * Interface FileStorageInterface
 * @package Dykyi\Clients
 */
interface FileStorageInterface
{
    /**
     * @param string $fileName
     * @param array $data
     * @return bool
     */
    public function save(string $fileName, array $data): bool;
}