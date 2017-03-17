<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\TypeHint;

use BetterReflection\Reflection\ReflectionMethod;

final class InputTypeHint
{
    public static function method(ReflectionMethod $method): \Iterator
    {
        foreach ($method->getParameters() as $parameter) {
            yield from ParamTypeHint::param($parameter);
        }
    }
}
