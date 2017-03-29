<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeCheckerTest\Anomaly;

use Marcosh\PhpTypeChecker\Anomaly\MissingFunctionReturnTypeWithDocBlock;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflector\FunctionReflector;
use Roave\BetterReflection\SourceLocator\Type\StringSourceLocator;

final class MissingFunctionReturnTypeWithDocBlockTest extends TestCase
{
    public function testCorrectMessage()
    {
        $php = '<?php
            /** @return int */
            function foo($x) {}
        ';

        $reflector = new FunctionReflector(new StringSourceLocator($php));
        $function = $reflector->reflect('foo');

        foreach(MissingFunctionReturnTypeWithDocBlock::function($function) as $anomaly) {
            self::assertSame(
                'Function <info>foo</info> defined in <comment></comment> ' .
                'does not have a return type but has a doc block return type of <info>int</info>.',
                $anomaly->message()
            );
        }
    }
}
