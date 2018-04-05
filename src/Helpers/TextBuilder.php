<?php

namespace Dykyi\Helpers;

/**
 * Class TextBuilder
 * @package Dykyi\Helpers
 */
final class TextBuilder
{
    private $text = [];

    /**
     * @param string $text
     * @param int $space
     *
     * @return TextBuilder $this
     */
    public function add(string $text, int $space = 0): self
    {
        $k = '';
        if ($space > 0){
            for($i = $space; $i >= 0; $i--){
                $k .= ' ';
            }
        }
        $this->text[] = $k . $text;

        return $this;
    }

    public function clear()
    {
        $this->text = [];
    }

    public function build(): array
    {
        return $this->text;
    }

    public static function create()
    {
        return new self();
    }

}