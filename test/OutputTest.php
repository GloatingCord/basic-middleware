<?php

namespace GloatingCord26\Testing;

use GloatingCord26\Index;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class OutputTest extends TestCase
{
    public function testExpectWordActualWord(): void
    {
        $this->expectOutputString('Hello world');

        $incomingString = new Index();
        echo $incomingString->index();
    }
}
