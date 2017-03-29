<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeCheckerTest\Anomaly;

use Marcosh\PhpTypeChecker\Anomaly\FunctionReturnTypeDoesNotCoincideWithDocBlock;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflector\FunctionReflector;
use Roave\BetterReflection\SourceLocator\Type\StringSourceLocator;

final class FunctionReturnTypeDoesNotCoincideWithDocBlockTest extends TestCase
{
    public function testCorrectMessage()
    {
        $php = '<?php
            /** @return int */
            function foo(): string {}
        ';

        $reflector = new FunctionReflector(new StringSourceLocator($php));
        $function = $reflector->reflect('foo');

        foreach(FunctionReturnTypeDoesNotCoincideWithDocBlock::function($function) as $anomaly) {
            self::assertSame(
                'Function <info>foo</info> defined ' .
                'in <comment></comment> has a <info>string</info> return type, ' .
                'but has a <info>int</info> return doc block.',
                $anomaly->message()
            );
        }
    }
}
