<?php

namespace Dykyi\Services\ParseService;

use Clue\React\Buzz\Browser;
use Dykyi\Helpers\UrlHelper;
use Dykyi\Services\Events\Event\SaveFileInTheStorageEvent;
use Dykyi\Services\Parser;
use Dykyi\Services\Service;
use Dykyi\ValueObjects\ReportItem;
use React\EventLoop\Factory;
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
     * @param string $url
     * @return array
     */
    private function parse(string $url): array
    {
        $result = [];
//        $urls = UrlHelper::getAllUrlsFromWebsite($url);
        $urls = ['https://m.rozetka.com.ua/'];
        $loop = Factory::create();
        $parser = new Parser(new Browser($loop), $loop);
        $parser->parse($urls, 2);
        $loop->run();

        $collection = collect($parser->getData());
        $sortResult = $collection->sortBy('tagCount');

        $sortResult->map(function ($item) use (&$result) {
            $result[] = new ReportItem(...array_values($item));
        });

        return $result;
    }

    /**
     * @param ParseRequest $request
     * @return void
     */
    public function execute(ParseRequest $request)
    {
        if (getenv('CACHE_USAGE'))
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
            exit;
        }

        $data = $this->parse($request->getUrl()->getUrlPath());
        $this->triggerEventSaveInTheStorage($data);
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