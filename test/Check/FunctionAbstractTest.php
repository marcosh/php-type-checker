<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeCheckerTest\Check;

use Marcosh\PhpTypeChecker\Check\FunctionAbstract;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflection\ReflectionFunction;

final class FunctionAbstractTest extends TestCase
{
    public function returnTypeDataProvider()
    {
        return [
            [function () {}, true, false, false],
            [function (): int {}, false, false, false],
            [/** @return int */function (): int {}, false, false, false],
            [/** @return int */function () {}, false, true, false],
            [/** @return int */function ():string {}, false, false, true]
        ];
    }

    /**
     * @dataProvider returnTypeDataProvider
     */
    public function testReturnType(
        $function,
        $missingReturnType,
        $missingReturnTypeWithDocBlock,
        $returnTypeDoesNotCoincideWithDocBlock
    ) {
        $reflection = ReflectionFunction::createFromClosure($function);

        $check = new FunctionAbstract($reflection);

        self::assertSame($missingReturnType, $check->missingReturnType());
        self::assertSame($missingReturnTypeWithDocBlock, $check->missingReturnTypeWithDocBlock());
        self::assertSame($returnTypeDoesNotCoincideWithDocBlock, $check->returnTypeDoesNotCoincideWithDocBlock());
    }
}