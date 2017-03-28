<?php

declare(strict_types = 1);

namespace Marcosh\PhpTypeChecker\TypeHint;

use Marcosh\PhpTypeChecker\Anomaly\FunctionReturnTypeDoesNotCoincideWithDocBlock;
use Marcosh\PhpTypeChecker\Anomaly\MethodReturnTypeDoesNotCoincideWithDocBlock;
use Marcosh\PhpTypeChecker\Anomaly\MissingFunctionReturnType;
use Marcosh\PhpTypeChecker\Anomaly\MissingFunctionReturnTypeWithDocBlock;
use Marcosh\PhpTypeChecker\Anomaly\MissingMethodReturnType;
use Marcosh\PhpTypeChecker\Anomaly\MissingMethodReturnTypeWithDocBlock;
use Roave\BetterReflection\Reflection\ReflectionFunction;
use Roave\BetterReflection\Reflection\ReflectionMethod;

final class ReturnTypeHint
{
    public static function method(ReflectionMethod $method): \Iterator
    {
        if ($method->isConstructor() || $method->isDestructor()) {
            return;
        }

        yield from MissingMethodReturnType::method($method);
        yield from MissingMethodReturnTypeWithDocBlock::method($method);
        yield from MethodReturnTypeDoesNotCoincideWithDocBlock::method($method);
    }

    public static function function(ReflectionFunction $function): \Iterator
    {
        yield from MissingFunctionReturnType::function($function);
        yield from MissingFunctionReturnTypeWithDocBlock::function($function);
        yield from FunctionReturnTypeDoesNotCoincideWithDocBlock::function($function);
    }
}
