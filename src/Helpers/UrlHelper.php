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
     * @return array
     */
    public static function getAllUrlsFromWebsite(string $url): array
    {
        $result = [];

        // need for parse ssl websites
//        $arrContextOptions=array(
//            "ssl"=>array(
//                "verify_peer"=>false,
//                "verify_peer_name"=>false,
//            ),
//        );
//        $html = file_get_contents($url, false, $arrContextOptions);
        $html = file_get_contents($url);
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $xpath = new \DOMXPath($dom);
        $nodes = $xpath->query('//a');

        foreach($nodes as $node) {
            $link = $node->getAttribute('href');
            if (
                (strpos($link,'http') !== false) ||
                (strpos($link,'#') !== false)
            ) {
                continue;
            }
            $result[] = $link;
        }

        return $result;
    }

    /**
     * @param string $url
     * @param string $tag
     * @return int
     */
    public static function getTagCountByUrl(string $url, $tag = 'img')
    {
        $html = file_get_contents($url);
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        return $dom->getElementsByTagName($tag)->length;
    }
}