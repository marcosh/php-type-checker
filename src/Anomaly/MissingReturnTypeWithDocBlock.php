<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker\Anomaly;

use Roave\BetterReflection\Reflection\ReflectionFunction;
use Roave\BetterReflection\Reflection\ReflectionMethod;

final class MissingReturnTypeWithDocBlock
{
    public static function method(ReflectionMethod $method): \Iterator
    {

    }

    public static function function(ReflectionFunction $function): \Iterator
    {

    }
}
