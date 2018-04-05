<?php

namespace Dykyi\CommandBus\Formatter;

use Dykyi\Helpers\TextBuilder;

/**
 * Class ConsoleFormatter
 * @package Dykyi\Formatter
 */
class ConsoleFormatter implements FormatterInterface
{
    /**
     * @param TextBuilder $text
     * @return string
     */
    public function format(TextBuilder $text): string
    {
        $result = '';
        foreach ($text->build() as $i => $line){
            $result .= $line . PHP_EOL;
        }
        return $result;
    }

    public static function create()
    {
        return new self;
    }
}