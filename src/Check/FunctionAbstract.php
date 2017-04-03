<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeChecker\Check;

use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Mixed;
use Roave\BetterReflection\Reflection\ReflectionFunctionAbstract;
use Roave\BetterReflection\Reflection\ReflectionType;

final class FunctionAbstract
{
    /**
     * @var ReflectionFunctionAbstract
     */
    private $function;

    public function __construct(ReflectionFunctionAbstract $function)
    {
        $this->function = $function;
    }

    /**
     * @return Type[]
     */
    private function returnDocBlockTypes(): array
    {
        $docBlockReturnTypes = [];

        try {
            $docBlockReturnTypes = $this->function->getDocBlockReturnTypes();
        } catch (\InvalidArgumentException $e) {
            // we need this here to prevent reflection-bocblock errors on @see invalid Fqsen
        }

        return $docBlockReturnTypes;
    }

    public function missingReturnType(): bool
    {
        return null === $this->function->getReturnType() &&
            empty($this->returnDocBlockTypes());
    }

    public function missingReturnTypeWithDocBlock(): bool
    {
        return null === $this->function->getReturnType() &&
            !empty($this->returnDocBlockTypes()) &&
            !$this->returnDocBlockTypes()[0] instanceof Mixed;
    }

    public function returnTypeDoesNotCoincideWithDocBlock(): bool
    {
        $docBlockReturnTypes = $this->returnDocBlockTypes();

        return !empty($docBlockReturnTypes) &&
            $this->function->getReturnType() instanceof ReflectionType &&
            !in_array($this->function->getReturnType()->getTypeObject(), $docBlockReturnTypes, false);
    }
}
