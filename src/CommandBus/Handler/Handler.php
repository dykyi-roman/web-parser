<?php

namespace Dykyi\CommandBus\Handler;

use Dykyi\CommandBus\Formatter\ConsoleFormatter;
use Dykyi\CommandBus\Formatter\FormatterInterface;
use Dykyi\Helpers\TextBuilder;

/**
 * Class Handler
 * @package Dykyi\CommandBus\Handler
 */
abstract class Handler
{
    /** @var TextBuilder  */
    private $responseText;

    /** @var  FormatterInterface */
    private $formatter;

    public function __construct()
    {
        $this->formatter    = ConsoleFormatter::create();
        $this->responseText = TextBuilder::create();
    }

    public function getResponse()
    {
        return $this->responseText;
    }

    public function getFormatter()
    {
        return $this->formatter;
    }
}