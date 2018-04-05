<?php

namespace Dykyi\Services\ParseService\Storage;

use Dykyi\ValueObjects\ReportItem;

/**
 * Class HTMLFileStorage
 * @package Dykyi\Services\ParseService\Clients
 */
class HTMLFileStorage implements FileStorageInterface
{
    /**
     * @param string $fileName
     * @param array $data
     *
     * @return bool
     */
    public function save(string $fileName, array $data): bool
    {
        $head = sprintf('<tr><td>%s</td><td>%s</td><td>%s</td></tr>',
            'Web url',
            'Tag count',
            'Processing Time'
            );

        $items = '';
        /** @var ReportItem $item */
        foreach ($data as $item)
        {
            $items .= sprintf('<tr><td>%s</td><td>%s</td><td>%s</td></tr>',
                $item->getUrl(),
                $item->getTagCount(),
                $item->getProcessingTime()
            );
        }

        $html = sprintf('<html><body><table>%s%s</table></body></html>', $head, $items);

        return file_put_contents($fileName, $html) > 0;
    }
}