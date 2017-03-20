<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker;

use Marcosh\PhpReturnTypeChecker\TypeHint\InputTypeHint;
use Marcosh\PhpReturnTypeChecker\TypeHint\ReturnTypeHint;
use Roave\BetterReflection\Reflection\ReflectionMethod;
use Roave\BetterReflection\Reflector\ClassReflector;
use Roave\BetterReflection\Reflector\FunctionReflector;
use Roave\BetterReflection\SourceLocator\Type\DirectoriesSourceLocator;

final class Checker
{
    /**
     * @param string $path to be checked
     * @return ReflectionMethod[]
     */
    public function __invoke(string $path): \Iterator
    {
        $directoriesSourceLocator = new DirectoriesSourceLocator([$path]);

        $classReflector = new ClassReflector($directoriesSourceLocator);

        foreach($classReflector->getAllClasses() as $class) {
            $methods = $class->getImmediateMethods();

            foreach ($methods as $method) {
                yield from ReturnTypeHint::method($method);
                //yield from InputTypeHint::method($method);
            }
        }

        $functionReflector = new FunctionReflector($directoriesSourceLocator);

        foreach ($functionReflector->getAllFunctions() as $function) {
            yield from ReturnTypeHint::function($function);
            //yield from InputTypeHint::function($function);
        }
    }
}
