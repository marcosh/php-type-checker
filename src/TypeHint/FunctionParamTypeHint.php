<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\TypeHint;

use Marcosh\PhpReturnTypeChecker\Anomaly\FunctionParamTypeDoesNotCoincideWithDocBlock;
use Marcosh\PhpReturnTypeChecker\Anomaly\MissingFunctionParamType;
use Marcosh\PhpReturnTypeChecker\Anomaly\MissingFunctionParamTypeWithDocBlock;
use Roave\BetterReflection\Reflection\ReflectionParameter;

final class FunctionParamTypeHint
{
    public static function param(ReflectionParameter $parameter): \Iterator
    {
        yield from MissingFunctionParamType::param($parameter);
        yield from MissingFunctionParamTypeWithDocBlock::param($parameter);
        yield from FunctionParamTypeDoesNotCoincideWithDocBlock::param($parameter);
    }
}
