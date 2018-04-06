<?php

namespace Dykyi\Services;

use Clue\React\Buzz\Browser;
use Dykyi\Helpers\UrlHelper;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;

/**
 * Class Parser
 * @package Dykyi\Services
 */
class Parser
{
    /**
     * @var Browser
     */
    private $client;
    /**
     * @var array
     */
    private $parsed = [];
    /**
     * @var LoopInterface
     */
    private $loop;

    public function __construct(Browser $client, LoopInterface $loop)
    {
        $this->client = $client;
        $this->loop = $loop;
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
     * @param array $urls
     * @param int $timeout
     */
    public function parse(array $urls = [], int $timeout = 5)
    {
        foreach ($urls as $url) {
            $promise = $this->client->get($url)->then(
                function (\Psr\Http\Message\ResponseInterface $response) use ($url) {
                    $time = $this->getTime();
                    $this->parsed[] = [
                        'url'      => $url,
                        'tagCount' => UrlHelper::getTagCountByUrl((string)$response->getBody(), getenv('SEARCH_TAG')),
                        'time'     => round($this->getTime($time), 3),
                    ];
                });

            $this->loop->addTimer($timeout, function () use ($promise) {
                $promise->cancel();
            });
        }
    }

    public function getData(): array
    {
        return $this->parsed;
    }
}