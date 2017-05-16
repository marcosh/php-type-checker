<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeCheckerTest\Check;

use Marcosh\PhpTypeChecker\Check\FunctionAbstract;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflection\ReflectionFunction;
use Roave\BetterReflection\Reflection\ReflectionFunctionAbstract;
use Roave\BetterReflection\Reflection\ReflectionMethod;

final class FunctionAbstractTest extends TestCase
{
    /**
     * @return FunctionAbstractTest
     */
    private function self(): self {}

    /**
     * @return self
     */
    private function functionAbstractTest(): FunctionAbstractTest {}

    public function returnTypeDataProvider(): \Iterator
    {
        yield [ReflectionFunction::createFromClosure(function () {}), true, false, false];
        yield [ReflectionFunction::createFromClosure(function (): int {}), false, false, false];
        yield [ReflectionFunction::createFromClosure(/** @return int */function (): int {}), false, false, false];
        yield [ReflectionFunction::createFromClosure(/** @return int */function () {}), false, true, false];
        yield [ReflectionFunction::createFromClosure(/** @return int */function ():string {}), false, false, true];
        yield [ReflectionFunction::createFromClosure(/** @return mixed */function () {}), false, false, false];
        yield [ReflectionFunction::createFromClosure(/** @return object */function () {}), false, false, false];
        yield [ReflectionFunction::createFromClosure(/** @return int[] */function (): array {}), false, false, false];
        yield [ReflectionMethod::createFromInstance($this, 'self'), false, false, false];
        yield [ReflectionMethod::createFromInstance($this, 'functionAbstractTest'), false, false, false];
    }

    /**
     * @dataProvider returnTypeDataProvider
     */
    public function testReturnType(
        ReflectionFunctionAbstract $function,
        bool $missingReturnType,
        bool $missingReturnTypeWithDocBlock,
        bool $returnTypeDoesNotCoincideWithDocBlock
    ) {
        $check = new FunctionAbstract($function);

        self::assertSame($missingReturnType, $check->missingReturnType());
        self::assertSame($missingReturnTypeWithDocBlock, $check->missingReturnTypeWithDocBlock());
        self::assertSame($returnTypeDoesNotCoincideWithDocBlock, $check->returnTypeDoesNotCoincideWithDocBlock());
    }
}
