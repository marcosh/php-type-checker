<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\TypeHint;

use Marcosh\PhpReturnTypeChecker\Anomaly\MissingMethodInputParamType;
use Roave\BetterReflection\Reflection\ReflectionParameter;

final class MethodParamTypeHint
{
    public static function param(ReflectionParameter $parameter): \Iterator
    {
        yield from MissingMethodInputParamType::param($parameter);
    }
}
