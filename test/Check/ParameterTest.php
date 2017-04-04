<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeCheckerTest\Check;

use Marcosh\PhpTypeChecker\Check\Parameter;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflection\ReflectionParameter;

final class ParameterTest extends TestCase
{
    /**
     * @param ParameterTest $x
     */
    private function self(self $x) {}

    /**
     * @param self $x
     */
    private function parameterTest(ParameterTest $x) {}

    public function parameterDataProvider(): \Iterator
    {
        yield [ReflectionParameter::createFromClosure(function ($x) {}, 'x'), true, false, false];
        yield [ReflectionParameter::createFromClosure(function (int $x) {}, 'x'), false, false, false];
        yield [ReflectionParameter::createFromClosure(/** @param int $x */function (int $x) {}, 'x'), false, false, false];
        yield [ReflectionParameter::createFromClosure(/** @param int $x */function ($x) {}, 'x'), false, true, false];
        yield [ReflectionParameter::createFromClosure(/** @param int $x */function (string $x) {}, 'x'), false, false, true];
        yield [ReflectionParameter::createFromClosure(/** @param mixed $x */function ($x) {}, 'x'), false, false, false];
        yield [ReflectionParameter::createFromClosure(/** @param int[] $x */function (array $x) {}, 'x'), false, false, false];
        yield [ReflectionParameter::createFromClassInstanceAndMethod($this, 'self', 'x'), false, false, false];
        yield [ReflectionParameter::createFromClassInstanceAndMethod($this, 'parameterTest', 'x'), false, false, false];
    }

    /**
     * @dataProvider parameterDataProvider
     */
    public function testParameter(
        ReflectionParameter $parameter,
        bool $typeMissing,
        bool $typeMissingWithDocBlock,
        bool $typeDoesNotCoincideWithDocBlock
    ) {
        $check = new Parameter($parameter);

        self::assertSame($typeMissing, $check->typeIsMissing());
        self::assertSame($typeMissingWithDocBlock, $check->typeIsMissingWithDocBlock());
        self::assertSame($typeDoesNotCoincideWithDocBlock, $check->typeDoesNotCoincideWithDocBlock());
    }
}
