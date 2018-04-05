<?php

namespace Dykyi\CommandBus\Formatter;

use Dykyi\Helpers\TextBuilder;

/**
 * Class HtmlFormatter
 * @package Dykyi\Formatter
 */
class HtmlFormatter implements FormatterInterface
{

    public function format(TextBuilder $text): string
    {
        return '';
    }
}