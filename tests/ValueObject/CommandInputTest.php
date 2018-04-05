<?php

use PHPUnit\Framework\TestCase;

/**
 * Class CommandInputTest
 *
 * @coversDefaultClass CommandInput
 */
class CommandInputTest extends TestCase
{

    /**
     * @covers ::fromInput
     */
    public function testCopiedInputShouldRepresentSameValue()
    {
        $input = new \Dykyi\ValueObjects\CommandInput(['index.php', 'version']);
        $copiedInput = \Dykyi\ValueObjects\CommandInput::fromInput($input);
        $this->assertTrue($input->equals($copiedInput));
    }

    /**
     * @covers ::fromInput
     */
    public function testGetCommandFromInput()
    {
        $input = new \Dykyi\ValueObjects\CommandInput(['index.php', 'version']);
        $this->assertEquals('version', $input->getCommand());
        $this->assertArrayNotHasKey('test', $input->getOptions());
    }
}