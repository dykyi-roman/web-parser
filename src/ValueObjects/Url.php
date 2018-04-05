<?php

namespace Dykyi\ValueObjects;
use PharIo\Manifest\InvalidUrlException;

/**
 * Class City
 * @package Dykyi\ValueObjects
 */
class Url
{
    const MIN_LENGTH = 5;
    const MAX_LENGTH = 2048;

    private $url;

    /**
     * CityName constructor.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->setUrl(trim($url));
    }

    /**
     * @return string
     */
    public function getUrlPath(): string
    {
        return $this->url;
    }

    private function setUrl(string $url)
    {
        $this->assertNotEmpty($url);
        $this->assertFitsLength($url);
        $this->assertValidation($url);
        $this->url = $url;
    }

    private function assertValidation(string $url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL, array(FILTER_FLAG_SCHEME_REQUIRED, FILTER_FLAG_HOST_REQUIRED))) {
            throw new InvalidUrlException('The specified URL is invalid.', 4);
        }
    }

    private function assertNotEmpty(string $url)
    {
        if (empty($url)) {
            throw new \DomainException('Empty url', 1);
        }
    }

    private function assertFitsLength(string $url)
    {
        if (strlen($url) < self::MIN_LENGTH) {
            throw new \DomainException('Url is too short', 2);
        }

        if (strlen($url) > self::MAX_LENGTH) {
            throw new \DomainException('Url is too long', 3);
        }
    }
}