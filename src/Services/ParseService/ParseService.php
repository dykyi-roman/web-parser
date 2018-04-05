<?php

namespace Dykyi\Services\ParseService;

use Dykyi\Helpers\UrlHelper;
use Dykyi\Services\Events\Event\SaveFileInTheStorageEvent;
use Dykyi\Services\Service;
use Dykyi\ValueObjects\ReportItem;
use Stash\Interfaces\DriverInterface;
use Stash\Pool;

/**
 * Class ParseService
 * @package Dykyi\Service
 */
class ParseService extends Service
{
    /** @var DriverInterface */
    private $cache;

    public function __construct(DriverInterface $cache)
    {
        parent::__construct();
        $this->cache = new Pool($cache);
    }

    /**
     * @param bool $time
     * @return bool|mixed
     */
    protected function getTime($time = false)
    {
        return $time === false ? microtime(true) : microtime(true) - $time;
    }

    /**
     * @param string $url
     * @return array
     */
    private function parse(string $url): array
    {
        $result = [];
        $urls = UrlHelper::getAllUrlsFromWebsite($url);
        foreach ($urls as $one)
        {
            $time = $this->getTime();
            $tagCount = UrlHelper::getTagCountByUrl($url.$one, getenv('SEARCH_TAG'));
            $processingTime = $this->getTime($time);
            $result[] = new ReportItem($url.$one, $tagCount, round($processingTime,3));
        }

        return $result;
    }

    /**
     * @param ParseRequest $request
     * @return void
     */
    public function execute(ParseRequest $request)
    {
        $data = null;
        $key = str_replace('http://', '', $request->getUrl()->getUrlPath());
        $item = $this->cache->getItem($key);
        if($item->isMiss()) {
            $data = $this->parse($request->getUrl()->getUrlPath());
            $item->lock();
            $item->set($data);
            $item->expiresAfter(getenv('CACHE_EXPIRE'));
            $this->cache->save($item);
        }
        $this->triggerEventSaveInTheStorage($item->get() ?? $data);
    }

    /**
     * @param array $data
     */
    private function triggerEventSaveInTheStorage(array $data)
    {
        $fileFormat = getenv('FILE_FORMAT');
        $fileName = 'report_'.(new \DateTime('now'))->format('d.m.Y');
        $event = new SaveFileInTheStorageEvent($fileFormat, $fileName, $data);
        $this->getEventDispatcher()->dispatch('save.file.action', $event);
    }
}