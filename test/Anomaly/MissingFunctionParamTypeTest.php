<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeCheckerTest\Anomaly;

use Marcosh\PhpTypeChecker\Anomaly\MissingFunctionParamType;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflector\FunctionReflector;
use Roave\BetterReflection\SourceLocator\Type\StringSourceLocator;

final class MissingFunctionParamTypeTest extends TestCase
{
    public function testCorrectMessage()
    {
        $php = '<?php
            function foo($x) {}
        ';

        $reflector = new FunctionReflector(new StringSourceLocator($php));
        $function = $reflector->reflect('foo');

        $parameter = $function->getParameter('x');

        foreach(MissingFunctionParamType::param($parameter) as $anomaly) {
            self::assertSame(
                'Parameter <info>x</info> of function <info>foo</info> defined in <comment></comment> ' .
                'does not have a type hint.',
                $anomaly->message()
            );
        }
    }
}
