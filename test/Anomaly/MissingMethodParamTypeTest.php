<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeCheckerTest\Anomaly;

use Marcosh\PhpTypeChecker\Anomaly\MissingMethodParamType;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflector\ClassReflector;
use Roave\BetterReflection\SourceLocator\Type\StringSourceLocator;

final class MissingMethodParamTypeTest extends TestCase
{
    public function testCorrectMessage()
    {
        $php = '<?php
            class Foo {
                function foo($x) {}
            }
        ';

        $reflector = new ClassReflector(new StringSourceLocator($php));
        $class = $reflector->reflect('Foo');

        $method = $class->getMethod('foo');

        $parameter = $method->getParameter('x');

        foreach(MissingMethodParamType::param($parameter) as $anomaly) {
            self::assertSame(
                'Parameter <info>x</info> of method <info>foo</info> of the class <info>Foo</info> ' .
                'defined in <comment></comment> does not have a type hint.',
                $anomaly->message()
            );
        }
    }
}
