<?php

use PHPUnit\Framework\TestCase;

/**
 * Class TextBuilderTest
 *
 * @coversDefaultClass TextBuilder
 */
class TextBuilderTest extends TestCase
{
    /** @var \Dykyi\Helpers\TextBuilder */
    private $textBuilder;

    public function setUp()
    {
        $this->textBuilder = \Dykyi\Helpers\TextBuilder::create();
    }

    public function testCreate()
    {
        $this->assertInstanceOf(\Dykyi\Helpers\TextBuilder::class, $this->textBuilder);
    }

    public function testAdd()
    {
        $this->assertInstanceOf(\Dykyi\Helpers\TextBuilder::class, $this->textBuilder->add('test string'));
    }

    public function testBuild()
    {
        $this->textBuilder->clear();
        $this->textBuilder->add('test string');
        $this->assertSame(['test string'], $this->textBuilder->build());
    }
}
