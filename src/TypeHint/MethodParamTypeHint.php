<?php

declare(strict_types = 1);

namespace Marcosh\PhpTypeChecker\TypeHint;

use Marcosh\PhpTypeChecker\Anomaly\MethodParamTypeDoesNotCoincideWithDocBlock;
use Marcosh\PhpTypeChecker\Anomaly\MissingMethodParamType;
use Marcosh\PhpTypeChecker\Anomaly\MissingMethodParamTypeWithDocBlock;
use Roave\BetterReflection\Reflection\ReflectionParameter;

final class MethodParamTypeHint
{
    public static function param(ReflectionParameter $parameter): \Iterator
    {
        yield from MissingMethodParamType::param($parameter);
        yield from MissingMethodParamTypeWithDocBlock::param($parameter);
        yield from MethodParamTypeDoesNotCoincideWithDocBlock::param($parameter);
    }
}
