<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeCheckerTest\Anomaly;

use Marcosh\PhpTypeChecker\Anomaly\MethodReturnTypeDoesNotCoincideWithDocBlock;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflector\ClassReflector;
use Roave\BetterReflection\SourceLocator\Type\StringSourceLocator;

final class MethodReturnTypeDoesNotCoincideWithDocBlockTest extends TestCase
{
    public function testCorrectMessage()
    {
        $php = '<?php
            class Foo {
                /** @return int $x */
                function foo(): string {}
            }
        ';

        $reflector = new ClassReflector(new StringSourceLocator($php));
        $class = $reflector->reflect('Foo');

        $method = $class->getMethod('foo');

        foreach(MethodReturnTypeDoesNotCoincideWithDocBlock::method($method) as $anomaly) {
            self::assertSame(
                'Method <info>foo</info> of the class <info>Foo</info> defined ' .
                'in <comment></comment> has a <info>string</info> return type, ' .
                'but has a <info>int</info> return doc block.',
                $anomaly->message()
            );
        }
    }
}
