<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeCheckerTest\Anomaly;

use Marcosh\PhpTypeChecker\Anomaly\MissingFunctionReturnType;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflector\FunctionReflector;
use Roave\BetterReflection\SourceLocator\Type\StringSourceLocator;

final class MissingFunctionReturnTypeTest extends TestCase
{
    public function testCorrectMessage()
    {
        $php = '<?php
            function foo($x) {}
        ';

        $reflector = new FunctionReflector(new StringSourceLocator($php));
        $function = $reflector->reflect('foo');

        foreach(MissingFunctionReturnType::function($function) as $anomaly) {
            self::assertSame(
                'Function <info>foo</info> defined in <comment></comment> does ' .
                'not have a return type.',
                $anomaly->message()
            );
        }
    }
}
