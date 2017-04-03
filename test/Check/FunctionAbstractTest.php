<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeCheckerTest\Check;

use Marcosh\PhpTypeChecker\Check\FunctionAbstract;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflection\ReflectionFunction;

final class FunctionAbstractTest extends TestCase
{
    public function returnTypeDataProvider(): \Iterator
    {
        yield [function () {}, true, false, false];
        yield [function (): int {}, false, false, false];
        yield [/** @return int */function (): int {}, false, false, false];
        yield [/** @return int */function () {}, false, true, false];
        yield [/** @return int */function ():string {}, false, false, true];
        yield [/** @return mixed */function () {}, false, false, false];
        yield [/** @return int[] */function (): array {}, false, false, false];
    }

    /**
     * @dataProvider returnTypeDataProvider
     */
    public function testReturnType(
        callable $function,
        bool $missingReturnType,
        bool $missingReturnTypeWithDocBlock,
        bool $returnTypeDoesNotCoincideWithDocBlock
    ) {
        $reflection = ReflectionFunction::createFromClosure($function);

        $check = new FunctionAbstract($reflection);

        self::assertSame($missingReturnType, $check->missingReturnType());
        self::assertSame($missingReturnTypeWithDocBlock, $check->missingReturnTypeWithDocBlock());
        self::assertSame($returnTypeDoesNotCoincideWithDocBlock, $check->returnTypeDoesNotCoincideWithDocBlock());
    }
}
