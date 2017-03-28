<?php

declare(strict_types = 1);

namespace Marcosh\PhpTypeChecker\TypeHint;

use Marcosh\PhpTypeChecker\Anomaly\FunctionParamTypeDoesNotCoincideWithDocBlock;
use Marcosh\PhpTypeChecker\Anomaly\MissingFunctionParamType;
use Marcosh\PhpTypeChecker\Anomaly\MissingFunctionParamTypeWithDocBlock;
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
