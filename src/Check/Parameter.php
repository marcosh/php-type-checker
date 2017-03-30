<?php

declare(strict_types=1);

namespace Marcosh\PhpTypeChecker\Check;

use phpDocumentor\Reflection\Type;
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

    public function typeDoesNotCoincideWithDocBlock(): bool
    {
        try {
            $docBlockTypes = $this->parameter->getDocBlockTypes();
        } catch (\InvalidArgumentException $e) {
            // we need this here to prevent reflection-bocblock errors on @see invalid Fqsen
        }

        return !empty($docBlockTypes) &&
            $this->parameter->getTypeHint() instanceof Type &&
            !in_array($this->parameter->getTypeHint(), $docBlockTypes, false);
    }
}
