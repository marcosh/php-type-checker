<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeChecker\Check;

use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Mixed;
use Roave\BetterReflection\Reflection\ReflectionParameter;

final class Parameter
{
    /**
     * @var ReflectionParameter
     */
    private $parameter;

    public function __construct(ReflectionParameter $parameter)
    {
        $this->parameter = $parameter;
    }

    /**
     * @return Type[]
     */
    private function docBlockTypes(): array
    {
        $docBlockTypes = [];

        try {
            $docBlockTypes = $this->parameter->getDocBlockTypes();
        } catch (\InvalidArgumentException $e) {
            // we need this here to prevent reflection-bocblock errors on @see invalid Fqsen
        }

        return $docBlockTypes;
    }

    public function typeIsMissing(): bool
    {
        return null === $this->parameter->getTypeHint() &&
            empty($this->docBlockTypes());
    }

    public function typeIsMissingWithDocBlock(): bool
    {
        return null === $this->parameter->getTypeHint() &&
            !empty($this->docBlockTypes()) &&
            !$this->docBlockTypes()[0] instanceof Mixed;
    }

    public function typeDoesNotCoincideWithDocBlock(): bool
    {
        $docBlockTypes = $this->docBlockTypes();

        return !empty($docBlockTypes) &&
            $this->parameter->getTypeHint() instanceof Type &&
            !in_array($this->parameter->getTypeHint(), $docBlockTypes, false) &&
            !($this->parameter->getTypeHint() instanceof Array_ && $docBlockTypes[0] instanceof Array_);
    }
}
