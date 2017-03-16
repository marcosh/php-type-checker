<?php

declare(strict_types = 1);

namespace Marcosh\PhpReturnTypeChecker;

use BetterReflection\Reflection\ReflectionMethod;
use BetterReflection\Reflector\ClassReflector;
use BetterReflection\SourceLocator\Type\DirectoriesSourceLocator;
use phpDocumentor\Reflection\DocBlock;

final class Checker
{
    /**
     * @param string $path to be checked
     * @return ReflectionMethod[]
     */
    public function __invoke(string $path): \Iterator
    {
        $directoriesSourceLocator = new DirectoriesSourceLocator([$path]);
        $reflector = new ClassReflector($directoriesSourceLocator);

        foreach($reflector->getAllClasses() as $class) {
            $methods = $class->getImmediateMethods();

            foreach ($methods as $method) {
                if (!$method->isConstructor() && !$method->isDestructor() && null === $method->getReturnType()) {
                    yield $method;
                }
            }
        }
    }
}
