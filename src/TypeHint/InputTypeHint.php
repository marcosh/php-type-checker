<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\TypeHint;

use Roave\BetterReflection\Reflection\ReflectionFunction;
use Roave\BetterReflection\Reflection\ReflectionMethod;

final class InputTypeHint
{
    public static function method(ReflectionMethod $method): \Iterator
    {
        foreach ($method->getParameters() as $parameter) {
            yield from MethodParamTypeHint::param($parameter);
        }
    }

    public static function function(ReflectionFunction $function): \Iterator
    {
        foreach ($function->getParameters() as $parameter) {
            yield from FunctionParamTypeHint::param($parameter);
        }
    }
}
