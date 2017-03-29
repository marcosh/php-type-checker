<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeCheckerTest\Anomaly;

use Marcosh\PhpTypeChecker\Anomaly\MissingMethodReturnTypeWithDocBlock;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflector\ClassReflector;
use Roave\BetterReflection\SourceLocator\Type\StringSourceLocator;

final class MissingMethodReturnTypeWithDocBlockTest extends TestCase
{
    public function testCorrectMessage()
    {
        $php = '<?php
            class Foo {
                /** @return int */
                function foo() {}
            }
        ';

        $reflector = new ClassReflector(new StringSourceLocator($php));
        $class = $reflector->reflect('Foo');

        $method = $class->getMethod('foo');

        foreach(MissingMethodReturnTypeWithDocBlock::method($method) as $anomaly) {
            self::assertSame(
                'Method <info>foo</info> of the class <info>Foo</info> defined in <comment></comment> ' .
                'does not have a return type but has a doc block return type of <info>int</info>.',
                $anomaly->message()
            );
        }
    }
}
