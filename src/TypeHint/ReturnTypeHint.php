<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\TypeHint;

use Marcosh\PhpReturnTypeChecker\Anomaly\FunctionReturnTypeDoesNotCoincideWithDocBlock;
use Marcosh\PhpReturnTypeChecker\Anomaly\MethodReturnTypeDoesNotCoincideWithDocBlock;
use Marcosh\PhpReturnTypeChecker\Anomaly\MissingFunctionReturnType;
use Marcosh\PhpReturnTypeChecker\Anomaly\MissingFunctionReturnTypeWithDocBlock;
use Marcosh\PhpReturnTypeChecker\Anomaly\MissingMethodReturnType;
use Marcosh\PhpReturnTypeChecker\Anomaly\MissingMethodReturnTypeWithDocBlock;
use Roave\BetterReflection\Reflection\ReflectionFunction;
use Roave\BetterReflection\Reflection\ReflectionMethod;

final class ReturnTypeHint
{
    public static function method(ReflectionMethod $method): \Iterator
    {
        if ($method->isConstructor() || $method->isDestructor()) {
            return;
        }

        //yield from MissingMethodReturnType::method($method);
        yield from MissingMethodReturnTypeWithDocBlock::method($method);
        //yield from MethodReturnTypeDoesNotCoincideWithDocBlock::method($method);
    }

    public static function function(ReflectionFunction $function): \Iterator
    {
        yield from MissingFunctionReturnType::function($function);
        yield from MissingFunctionReturnTypeWithDocBlock::function($function);
        yield from FunctionReturnTypeDoesNotCoincideWithDocBlock::function($function);
    }
}
