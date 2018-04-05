<?php

namespace Dykyi\Helpers;

/**
 * Class UrlHelper
 * @package Dykyi\Helpers
 */
class UrlHelper
{
    /**
     * @param string $url
     * @return mixed
     */
    private static function getSslPage(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * @param string $url
     * @return \DOMDocument
     */
    private static function getDOM(string $url): \DOMDocument
    {
        $html = self::getSslPage($url);
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        return $dom;
    }

    /**
     * @param string $url
     * @return array
     */
    public static function getAllUrlsFromWebsite(string $url): array
    {
        $dom = self::getDOM($url);
        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query('//a');

        $result = [];
        foreach($nodes as $node) {
            $link = $node->getAttribute('href');
            if ($link[0] === '/')
            {
                $result[] = $url.$link;
            }elseif ($link !== '#' || strpos($link, $url) !== false) {
                $result[] = $link;
            }
        }

        return array_unique($result);
    }

    /**
     * @param string $url
     * @param string $tag
     * @return int
     */
    public static function getTagCountByUrl(string $url, $tag = 'img')
    {
       $dom = self::getDOM($url);

       return $dom->getElementsByTagName($tag)->length;
    }
}