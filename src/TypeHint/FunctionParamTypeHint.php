<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\TypeHint;

use Marcosh\PhpReturnTypeChecker\Anomaly\MissingFunctionInputParamType;
use Roave\BetterReflection\Reflection\ReflectionParameter;

final class FunctionParamTypeHint
{
    public static function param(ReflectionParameter $parameter): \Iterator
    {
        yield from MissingFunctionInputParamType::param($parameter);
    }
}
