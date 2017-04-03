<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeCheckerTest\Check;

use Marcosh\PhpTypeChecker\Check\Parameter;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflection\ReflectionParameter;

final class ParameterTest extends TestCase
{
    public function parameterDataProvider()
    {
        return [
            [ReflectionParameter::createFromClosure(function ($x) {}, 'x'), true, false, false],
            [ReflectionParameter::createFromClosure(function (int $x) {}, 'x'), false, false, false],
            [ReflectionParameter::createFromClosure(/** @param int $x */function (int $x) {}, 'x'), false, false, false],
            [ReflectionParameter::createFromClosure(/** @param int $x */function ($x) {}, 'x'), false, true, false],
            [ReflectionParameter::createFromClosure(/** @param int $x */function (string $x) {}, 'x'), false, false, true],
            [ReflectionParameter::createFromClosure(/** @param mixed $x */function ($x) {}, 'x'), false, false, false]
        ];
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
