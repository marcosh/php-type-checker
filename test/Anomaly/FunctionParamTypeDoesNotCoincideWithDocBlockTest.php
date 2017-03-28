<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeCheckerTest\Anomaly;

use Marcosh\PhpTypeChecker\Anomaly\FunctionParamTypeDoesNotCoincideWithDocBlock;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflector\FunctionReflector;
use Roave\BetterReflection\SourceLocator\Type\StringSourceLocator;

final class FunctionParamTypeDoesNotCoincideWithDocBlockTest extends TestCase
{
    public function testCorrectMessage()
    {
        $php = '<?php
            /** @param int $x */
            function foo(string $x) {}
        ';

        $reflector = new FunctionReflector(new StringSourceLocator($php));
        $function = $reflector->reflect('foo');

        $parameter = $function->getParameter('x');

        foreach(FunctionParamTypeDoesNotCoincideWithDocBlock::param($parameter) as $anomaly) {
            self::assertSame(
                'Parameter <info>x</info> of function <info>foo</info> ' .
                'defined in <comment></comment>  has a <info>string</info> type hint, ' .
                'but has a <info>int</info> doc block type.',
                $anomaly->message()
            );
        }
    }
}
