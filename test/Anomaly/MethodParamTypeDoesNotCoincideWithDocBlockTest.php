<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeCheckerTest\Anomaly;

use Marcosh\PhpTypeChecker\Anomaly\MethodParamTypeDoesNotCoincideWithDocBlock;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflector\ClassReflector;
use Roave\BetterReflection\SourceLocator\Type\StringSourceLocator;

final class MethodParamTypeDoesNotCoincideWithDocBlockTest extends TestCase
{
    public function testCorrectMessage()
    {
        $php = '<?php
            class Foo {
                /** @param int $x */
                function foo(string $x) {}
            }
        ';

        $reflector = new ClassReflector(new StringSourceLocator($php));
        $class = $reflector->reflect('Foo');

        $method = $class->getMethod('foo');

        $parameter = $method->getParameter('x');

        foreach(MethodParamTypeDoesNotCoincideWithDocBlock::param($parameter) as $anomaly) {
            self::assertSame(
                'Parameter <info>x</info> of method <info>foo</info> of the class <info>Foo</info> ' .
                'defined in <comment></comment>  has a <info>string</info> type hint, ' .
                'but has a <info>int</info> doc block type.',
                $anomaly->message()
            );
        }
    }
}
